#!/bin/bash
# Start the stack and theme tooling. Does NOT import the database — use scripts/db-import.sh for that.
# shellcheck disable=SC1091
set -euo pipefail
source ./.env

sh scripts/ssl-setup.sh

docker compose up -d --build

docker exec -i "${CLIENT_NAME}-wordpress" /bin/bash -c \
  'php /usr/local/bin/composer install && cd ${WP_THEME_PATH} && npm install && npm run start'
