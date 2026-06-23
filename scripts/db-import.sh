#!/bin/bash
# Import repo-root dump.sql into the MariaDB container.
# Expects Docker Compose to be up (run `sh scripts/install.sh` or `docker compose up -d` first).
# shellcheck disable=SC1091
set -euo pipefail
source ./.env

if ! docker inspect "${CLIENT_NAME}-db" >/dev/null 2>&1; then
  echo "db-import.sh: database container \"${CLIENT_NAME}-db\" not found. Start the stack first (e.g. sh scripts/install.sh or docker compose up -d)." >&2
  exit 1
fi

docker cp ./dump.sql "${CLIENT_NAME}-db:/"

i=0
while [ $i -lt 60 ]; do
  if docker exec -i "${CLIENT_NAME}-db" /bin/bash -c "mysqladmin ping -h 127.0.0.1 -u${DB_USER} -p${DB_PASSWORD} --silent" >/dev/null 2>&1; then
    break
  fi
  i=$((i + 1))
  sleep 2
done

if [ $i -ge 60 ]; then
  echo "db-import.sh: timed out waiting for MariaDB." >&2
  exit 1
fi

import_dump=0
if [ "${FORCE_DB_IMPORT:-}" = "1" ] || [ "${FORCE_DB_IMPORT:-}" = "true" ]; then
  echo "db-import.sh: FORCE_DB_IMPORT is set — importing dump.sql (replaces DB contents)."
  import_dump=1
elif [ "${SKIP_DB_IMPORT:-}" = "1" ] || [ "${SKIP_DB_IMPORT:-}" = "true" ]; then
  echo "db-import.sh: SKIP_DB_IMPORT is set — not importing dump.sql."
  import_dump=0
else
  post_count="$(
    docker exec "${CLIENT_NAME}-db" mysql -N -h 127.0.0.1 -P 3306 \
      -u"${DB_USER}" -p"${DB_PASSWORD}" "${DB_NAME}" \
      -e "SELECT COUNT(*) FROM ${DB_PREFIX}posts" 2>/dev/null | tr -d ' \r\n' || true
  )"
  if ! [[ "${post_count}" =~ ^[0-9]+$ ]]; then
    echo "db-import.sh: no posts table or empty DB — importing dump.sql."
    import_dump=1
  elif [ "${post_count}" -eq 0 ]; then
    echo "db-import.sh: posts count is 0 — importing dump.sql."
    import_dump=1
  else
    echo "db-import.sh: database already has content — skipping dump.sql (use FORCE_DB_IMPORT=1 to re-seed)."
    import_dump=0
  fi
fi

if [ "${import_dump}" -eq 1 ]; then
  docker exec -i "${CLIENT_NAME}-db" /bin/bash -c \
    "mysql -v -h 127.0.0.1 -P 3306 -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME} < /dump.sql"
fi
