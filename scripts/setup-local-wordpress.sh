#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOCAL_DIR="$ROOT_DIR/.local-wordpress"
WP_DIR="$LOCAL_DIR/wordpress"
DOWNLOADS_DIR="$LOCAL_DIR/downloads"
DATA_DIR="$LOCAL_DIR/data"

mkdir -p "$DOWNLOADS_DIR" "$DATA_DIR"

if [ ! -d "$WP_DIR" ]; then
  curl --fail --location --show-error \
    --output "$DOWNLOADS_DIR/wordpress.zip" \
    "https://wordpress.org/latest.zip"
  unzip -q "$DOWNLOADS_DIR/wordpress.zip" -d "$LOCAL_DIR"
fi

if [ ! -d "$WP_DIR/wp-content/plugins/sqlite-database-integration" ]; then
  curl --fail --location --show-error \
    --output "$DOWNLOADS_DIR/sqlite-database-integration.zip" \
    "https://downloads.wordpress.org/plugin/sqlite-database-integration.latest-stable.zip"
  unzip -q "$DOWNLOADS_DIR/sqlite-database-integration.zip" -d "$WP_DIR/wp-content/plugins"
fi

rm -rf "$WP_DIR/wp-content/themes"
ln -s "$ROOT_DIR/themes" "$WP_DIR/wp-content/themes"

if [ -f "$WP_DIR/wp-content/plugins/sqlite-database-integration/db.copy" ]; then
  cp "$WP_DIR/wp-content/plugins/sqlite-database-integration/db.copy" "$WP_DIR/wp-content/db.php"
elif [ -f "$WP_DIR/wp-content/plugins/sqlite-database-integration/db.php" ]; then
  cp "$WP_DIR/wp-content/plugins/sqlite-database-integration/db.php" "$WP_DIR/wp-content/db.php"
else
  echo "SQLite drop-in non trovato nel plugin." >&2
  exit 1
fi

SALT="$(curl --fail --silent --show-error https://api.wordpress.org/secret-key/1.1/salt/ || true)"
if [ -z "$SALT" ]; then
  SALT="$(cat <<'SALTS'
define('AUTH_KEY',         'local-auth-key');
define('SECURE_AUTH_KEY',  'local-secure-auth-key');
define('LOGGED_IN_KEY',    'local-logged-in-key');
define('NONCE_KEY',        'local-nonce-key');
define('AUTH_SALT',        'local-auth-salt');
define('SECURE_AUTH_SALT', 'local-secure-auth-salt');
define('LOGGED_IN_SALT',   'local-logged-in-salt');
define('NONCE_SALT',       'local-nonce-salt');
SALTS
)"
fi

cat > "$WP_DIR/wp-config.php" <<PHP
<?php
define( 'DB_NAME', 'local' );
define( 'DB_USER', 'local' );
define( 'DB_PASSWORD', 'local' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define( 'DB_DIR', '$DATA_DIR/' );
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_HOME', 'http://localhost:8080' );
define( 'WP_SITEURL', 'http://localhost:8080' );
define( 'FS_METHOD', 'direct' );

$SALT

\$table_prefix = 'wp_';

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
PHP

php "$ROOT_DIR/scripts/wp-local-install.php"

echo "WordPress locale pronto in $WP_DIR"
