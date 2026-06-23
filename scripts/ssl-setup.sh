#!/bin/bash
# Generate or refresh locally trusted TLS for *.ssl.localhost and install the dev CA.
# Run from repo root: sh scripts/ssl-setup.sh
# Requires: openssl. Optional: mkcert (preferred when installed).
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

# shellcheck disable=SC1091
source ./.env

DOCKER_DIR="${ROOT}/.docker"
THEME_SSL="${ROOT}/${WP_THEME_PATH}/local-ssl"
HOSTNAME="${DOCKER_HOSTNAME}"
CONTAINER="${CLIENT_NAME}-wordpress"

mkdir -p "$DOCKER_DIR" "$THEME_SSL"

generate_with_mkcert() {
  if ! command -v mkcert >/dev/null 2>&1; then
    return 1
  fi

  echo "Using mkcert to generate trusted certificates..."
  mkcert -install
  mkcert -cert-file "${DOCKER_DIR}/server.crt" -key-file "${DOCKER_DIR}/server.key" \
    "*.ssl.localhost" "ssl.localhost" "localhost" "127.0.0.1" "::1" "${HOSTNAME}"
  return 0
}

generate_with_openssl() {
  echo "Using OpenSSL local CA (install mkcert for simpler trust: brew install mkcert)..."

  if [[ ! -f "${DOCKER_DIR}/ca.crt" || ! -f "${DOCKER_DIR}/ca.key" ]]; then
    openssl genrsa -out "${DOCKER_DIR}/ca.key" 4096
    openssl req -x509 -new -nodes -key "${DOCKER_DIR}/ca.key" -sha256 -days 825 \
      -out "${DOCKER_DIR}/ca.crt" -subj "/CN=Tall Local Dev CA"
  fi

  openssl genrsa -out "${DOCKER_DIR}/server.key" 2048
  openssl req -new -key "${DOCKER_DIR}/server.key" -out "${DOCKER_DIR}/server.csr" \
    -subj "/CN=*.ssl.localhost" -config "${DOCKER_DIR}/openssl.cnf"
  openssl x509 -req -in "${DOCKER_DIR}/server.csr" \
    -CA "${DOCKER_DIR}/ca.crt" -CAkey "${DOCKER_DIR}/ca.key" -CAcreateserial \
    -out "${DOCKER_DIR}/server.crt" -days 825 -sha256 \
    -extfile "${DOCKER_DIR}/openssl.cnf" -extensions v3_server
  rm -f "${DOCKER_DIR}/server.csr"
}

trust_certificates() {
  if [[ "$(uname -s)" != "Darwin" ]]; then
    echo "Trust step skipped (macOS only). Import ${DOCKER_DIR}/ca.crt into your OS trust store."
    return 0
  fi

  if [[ ! -t 0 ]] || [[ "${SKIP_SSL_TRUST:-}" == "1" ]]; then
    echo "Skipping auto-trust (non-interactive). To trust in the browser, run:"
    echo "  sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain ${DOCKER_DIR}/ca.crt"
    return 0
  fi

  local cert_to_trust="${DOCKER_DIR}/ca.crt"

  echo "Adding dev CA to macOS trust store (will prompt for password)..."
  if security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain "$cert_to_trust"; then
    echo "CA trusted in System keychain."
  else
    echo "Could not auto-trust the CA. Double-click ${cert_to_trust} in Keychain Access and set Trust to Always Trust."
  fi
}

sync_certs() {
  cp "${DOCKER_DIR}/server.crt" "${THEME_SSL}/server.crt"
  cp "${DOCKER_DIR}/server.key" "${THEME_SSL}/server.key"
  chmod 644 "${THEME_SSL}/server.crt"
  chmod 600 "${THEME_SSL}/server.key" "${DOCKER_DIR}/server.key"
  echo "Copied certs to ${THEME_SSL}/"
}

reload_apache() {
  if ! docker ps --format '{{.Names}}' | grep -qx "$CONTAINER"; then
    echo "Container ${CONTAINER} not running — start with: docker compose up -d"
    return 0
  fi

  docker compose up -d
  docker exec "$CONTAINER" apachectl graceful
  echo "Apache reloaded in ${CONTAINER} (certs mounted from .docker/)."
}

if generate_with_mkcert; then
  :
else
  generate_with_openssl
  trust_certificates
fi

sync_certs
reload_apache

echo ""
echo "TLS ready for https://${HOSTNAME}"
echo "If the browser still warns, quit Chrome completely and reopen, or run: sh scripts/ssl-setup.sh"
