#!/bin/bash
set -euo pipefail
# shellcheck disable=SC1091
source .env

docker exec -it "${CLIENT_NAME}-wordpress" /bin/bash -c 'php /usr/local/bin/composer install && cd ${WP_THEME_PATH} && npm install && npm run build'
