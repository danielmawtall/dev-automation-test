#!/bin/bash
set -euo pipefail
# shellcheck disable=SC1091
source .env

cd "${WP_THEME_PATH}"

if [ -f "package-lock.json" ]; then
  npm ci
else
  npm install
fi
npm run build
