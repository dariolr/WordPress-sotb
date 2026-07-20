#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOCAL_DIR="$ROOT_DIR/.local-wordpress"
DEPLOY_DIR="$LOCAL_DIR/deploy"
COOKIE_FILE="$LOCAL_DIR/prod.cookies"
THEME_SLUG="${THEME_SLUG:-sotb}"

# Carica configurazione da file non versionato (se presente)
SECRETS_FILE="$ROOT_DIR/.env.secrets"
if [ -f "$SECRETS_FILE" ]; then
  set -a
  . "$SECRETS_FILE"
  set +a
fi

SITE_URL="${SITE_URL:-}"
WP_LOGIN_PATH="${WP_LOGIN_PATH:-}"
WP_ADMIN_PATH="${WP_ADMIN_PATH:-}"
WP_USER="${WP_USER:-}"
WP_PASS="${WP_PASS:-}"
THEME_DIR="$ROOT_DIR/themes/$THEME_SLUG"
ZIP_FILE="$DEPLOY_DIR/$THEME_SLUG.zip"

if [ -z "$SITE_URL" ] || [ -z "$WP_USER" ] || [ -z "$WP_PASS" ]; then
  cat >&2 <<'MSG'
Missing configuration.

Create a .env.secrets file in the project root with:
  SITE_URL='https://tuodominio.it'
  WP_LOGIN_PATH='/wp/wp-login.php'
  WP_ADMIN_PATH='/wp/wp-admin'
  WP_USER='tuo_utente_wp'
  WP_PASS='tua_password_wp'

Or override via environment variables:
  SITE_URL='...' WP_USER='...' WP_PASS='...' ./scripts/deploy-production.sh
MSG
  exit 1
fi

require_cmd() {
  if ! command -v "$1" >/dev/null 2>&1; then
    echo "Required command not found: $1" >&2
    exit 1
  fi
}

require_cmd curl
require_cmd php
require_cmd python3
require_cmd zip

if [ ! -d "$THEME_DIR" ]; then
  echo "Theme directory not found: $THEME_DIR" >&2
  exit 1
fi

mkdir -p "$DEPLOY_DIR"
rm -f "$COOKIE_FILE" "$ZIP_FILE"

echo "1/6 Lint PHP theme files"
find "$THEME_DIR" -name '*.php' -print -exec php -l {} \; >/dev/null

echo "2/6 Build theme ZIP"
(
  cd "$ROOT_DIR/themes"
  zip -qr "$ZIP_FILE" "$THEME_SLUG" \
    -x "$THEME_SLUG/assets/img/beach-volley-hero-no-logo.png"
)

echo "3/6 Login to WordPress admin"
curl --fail --silent --show-error \
  -c "$COOKIE_FILE" \
  -b "$COOKIE_FILE" \
  "$SITE_URL$WP_LOGIN_PATH" \
  > "$DEPLOY_DIR/login.html"

curl --fail --silent --show-error --location \
  -c "$COOKIE_FILE" \
  -b "$COOKIE_FILE" \
  --data-urlencode "log=$WP_USER" \
  --data-urlencode "pwd=$WP_PASS" \
  --data-urlencode "wp-submit=Log In" \
  --data-urlencode "redirect_to=$SITE_URL$WP_ADMIN_PATH/" \
  --data-urlencode "testcookie=1" \
  "$SITE_URL$WP_LOGIN_PATH" \
  > "$DEPLOY_DIR/admin.html"

python3 - "$DEPLOY_DIR/admin.html" <<'PY'
import pathlib
import sys

html = pathlib.Path(sys.argv[1]).read_text(encoding="utf-8", errors="ignore")
markers = ("wp-admin-bar", "Dashboard", "Bacheca", "wp-admin/profile.php")
if not any(marker in html for marker in markers):
    raise SystemExit("WordPress login failed.")
PY

echo "4/6 Upload theme ZIP"
curl --fail --silent --show-error \
  -b "$COOKIE_FILE" \
  "$SITE_URL$WP_ADMIN_PATH/theme-install.php?browse=upload" \
  > "$DEPLOY_DIR/theme-upload.html"

UPLOAD_NONCE="$(
  python3 - "$DEPLOY_DIR/theme-upload.html" <<'PY'
import pathlib
import re
import sys

html = pathlib.Path(sys.argv[1]).read_text(encoding="utf-8", errors="ignore")
m = re.search(r'name="_wpnonce" value="([^"]+)"', html)
if not m:
    raise SystemExit("Upload nonce not found.")
print(m.group(1))
PY
)"

curl --fail --silent --show-error --location \
  -b "$COOKIE_FILE" \
  -c "$COOKIE_FILE" \
  -F "_wpnonce=$UPLOAD_NONCE" \
  -F "themezip=@$ZIP_FILE;type=application/zip" \
  -F "install-theme-submit=Install Now" \
  "$SITE_URL$WP_ADMIN_PATH/update.php?action=upload-theme" \
  > "$DEPLOY_DIR/theme-upload-result.html"

OVERWRITE_URL="$(
  python3 - "$DEPLOY_DIR/theme-upload-result.html" "$SITE_URL$WP_ADMIN_PATH/" <<'PY'
import pathlib
import re
import sys
from urllib.parse import urljoin

html = pathlib.Path(sys.argv[1]).read_text(encoding="utf-8", errors="ignore")
base_url = sys.argv[2]
for m in re.finditer(r'<a[^>]+href="([^"]+)"[^>]*>(.*?)</a>', html, re.S):
    text = re.sub(r"<.*?>", "", m.group(2)).strip().lower()
    href = m.group(1).replace("&amp;", "&")
    if "sostituisci" in text or "replace" in text:
        print(urljoin(base_url, href))
        break
else:
    if "Theme installed successfully" in html or "Tema installato correttamente" in html:
        print("")
    else:
        raise SystemExit("Theme overwrite link not found; inspect theme-upload-result.html.")
PY
)"

if [ -n "$OVERWRITE_URL" ]; then
  echo "5/6 Confirm theme overwrite"
  curl --fail --silent --show-error --location \
    -b "$COOKIE_FILE" \
    -c "$COOKIE_FILE" \
    "$OVERWRITE_URL" \
    > "$DEPLOY_DIR/theme-overwrite-result.html"
else
  echo "5/6 Theme did not need overwrite confirmation"
  cp "$DEPLOY_DIR/theme-upload-result.html" "$DEPLOY_DIR/theme-overwrite-result.html"
fi

python3 - "$DEPLOY_DIR/theme-overwrite-result.html" <<'PY'
import pathlib
import sys

html = pathlib.Path(sys.argv[1]).read_text(encoding="utf-8", errors="ignore")
success = (
    "Theme updated successfully" in html
    or "Tema aggiornato correttamente" in html
    or "Theme installed successfully" in html
    or "Tema installato correttamente" in html
)
failed = "Update failed" in html or "Aggiornamento fallito" in html
if failed or not success:
    raise SystemExit("Theme upload did not report success; inspect theme-overwrite-result.html.")
PY

echo "6/6 Verify production"
STAMP="$(date +%Y%m%d%H%M%S)"
for page in "/" "/news/" "/tornei/" "/contatti/"; do
  code="$(curl --silent --show-error --location --output /dev/null --write-out '%{http_code}' "$SITE_URL$page?v=$STAMP")"
  if [ "$code" != "200" ]; then
    echo "Verification failed for $page: HTTP $code" >&2
    exit 1
  fi
  echo "  $page HTTP $code"
done

curl --fail --silent --show-error --head \
  "$SITE_URL/wp/wp-content/themes/$THEME_SLUG/assets/img/beach-volley-hero.webp?v=$STAMP" \
  >/dev/null

curl --fail --silent --show-error \
  "$SITE_URL/wp/wp-content/themes/$THEME_SLUG/style.css?v=$STAMP" \
  | grep -q "NEWS EDITORIAL SKIN"

echo "Deploy complete: $SITE_URL"
