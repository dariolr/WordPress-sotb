#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
WP_DIR="$ROOT_DIR/.local-wordpress/wordpress"

if [ ! -f "$WP_DIR/wp-config.php" ]; then
  "$ROOT_DIR/scripts/setup-local-wordpress.sh"
fi

php -S localhost:8080 -t "$WP_DIR"
