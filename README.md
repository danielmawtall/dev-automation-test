# Tall AI Dev Test — WordPress (Bedrock + Docker)

Tall AI Dev Test is a Bedrock WordPress site for the Tall Website 2025 design system. It runs in Docker with a custom **ai-dev** theme (ACF blocks, webpack, SCSS + BEM). Local URL: **https://auto-build-test.ssl.localhost**.

Build documentation lives in `docs/build/` (design spec, content model, QA).

---

## Table of Contents

- [Architecture overview](#architecture-overview)
- [Core framework: Bedrock](#core-framework-bedrock)
- [Docker environment](#docker-environment)
- [Environment configuration](#environment-configuration)
- [Development tools](#development-tools)
- [Project scripts](#project-scripts)
- [Database management](#database-management)
- [Manual plugin installs](#manual-plugin-installs)
- [Getting started](#getting-started)
- [Common issues](#common-issues)
- [Contributing](#contributing)

---

## Architecture overview

```
auto-build-test/
├── config/                 # Bedrock application config
├── docs/build/             # Build manifest, design spec, QA
├── scripts/                # install, build, db-import, deployhq
├── web/
│   ├── app/
│   │   ├── mu-plugins/
│   │   ├── plugins/        # Composer-managed plugins
│   │   ├── themes/ai-dev/  # Active theme
│   │   └── uploads/
│   ├── index.php
│   └── wp/                 # WordPress core (Composer, gitignored)
├── .docker/                # Dockerfile, TLS certs, Apache vhost
├── composer.json
├── docker-compose.yml
└── .env                    # Local secrets (not committed)
```

- **Composer** manages WordPress core and wpackagist plugins.
- **Content directory** is `web/app/` (`CONTENT_DIR` = `/app`).
- **Theme** uses PHP-registered ACF field groups (no `acf-json/`).

---

## Core framework: Bedrock

Based on [Roots Bedrock](https://roots.io/bedrock/). Key packages from `composer.json`:

| Package | Version |
|---------|---------|
| roots/wordpress | 6.9.4 |
| wpackagist-plugin/wordpress-seo | ^26 |
| wpackagist-plugin/redirection | ^5 |
| wpackagist-plugin/acf-extended | ^0.9 |

Config: `config/application.php` with environment overrides in `config/environments/`.

---

## Docker environment

| Service | Image / build | Ports |
|---------|---------------|-------|
| wordpress | `.docker/Dockerfile` (PHP 8.4 Apache) | 80, 443, 3000 |
| db | mariadb:10.4 | `${DB_EXTERNAL_PORT}:3306` |

Container names: `${CLIENT_NAME}-wordpress`, `${CLIENT_NAME}-db`.

Run CLI commands inside the wordpress container when the stack is up.

---

## Environment configuration

Copy `.env.example` to `.env` and set:

| Variable | Example |
|----------|---------|
| CLIENT_NAME | auto-build-test |
| DOCKER_HOSTNAME | auto-build-test.ssl.localhost |
| WP_HOME | https://auto-build-test.ssl.localhost |
| WP_THEME_PATH | web/app/themes/ai-dev |
| DB_NAME | wp_auto_build_test |
| DB_EXTERNAL_PORT | 3310 |

Generate salts at [roots.io/salts.html](https://roots.io/salts.html).

---

## Development tools

- **Composer** — inside `${CLIENT_NAME}-wordpress` container
- **WP-CLI** — `wp-cli.yml` points to `web/wp`
- **Node 20** — in Docker image; theme at `web/app/themes/ai-dev`
- **Webpack** — `npm run start` (watch) / `npm run build` (production)

---

## Project scripts

| Script | Purpose |
|--------|---------|
| `scripts/install.sh` | TLS copy, `docker compose up -d --build`, composer + npm install + `npm run start` |
| `scripts/db-import.sh` | Import `dump.sql` when present |
| `scripts/build.sh` | Interactive container build (composer + npm run build) |
| `scripts/deployhq-build.sh` | Host-only theme production build |
| `scripts/setup-module-library.sh` | Module library pages (Figma Module List groups) |
| `scripts/qa-module-library.sh` | Structural QA gates for `/modules/` pages |

---

## Database management

- Host port: `${DB_EXTERNAL_PORT}` (default 3310)
- Container host: `db`
- Place `dump.sql` at repo root for `db-import.sh`

---

## Manual plugin installs

These are **not** in Composer and must be installed manually:

- **ACF Pro** — required for blocks
- **Gravity Forms** — contact / Let's Talk forms

Document license paths in your local workflow; never commit ZIPs or keys.

---

## Getting started

1. Install Docker Desktop.
2. `cp .env.example .env` and configure.
3. `sh scripts/install.sh` (blocks on webpack watch).
4. In a second terminal: `sh scripts/db-import.sh` if you have a dump.
5. `sh scripts/ssl-setup.sh` — generates trusted local TLS for `*.ssl.localhost` (run once per machine).
6. Open https://auto-build-test.ssl.localhost (no certificate warning after step 5).
7. Activate the **AI Dev** theme; install ACF Pro and Gravity Forms.

---

## Common issues

| Issue | Fix |
|-------|-----|
| SSL warning | Run `sh scripts/ssl-setup.sh`, then trust the CA: `sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain .docker/ca.crt` (or install [mkcert](https://github.com/FiloSottile/mkcert)) |
| Port conflict | Change `DB_EXTERNAL_PORT` in `.env` |
| Theme assets missing | `cd web/app/themes/ai-dev && npm run build` |
| Blocks not showing | Confirm ACF Pro is active |

---

## Contributing

- Do not commit `.env`, `vendor/`, `web/wp/`, `node_modules/`, or premium plugin files.
- Run `npm run build` before deploy.
- See `docs/build/BUILD_MANIFEST.md` for build phase status.

---

Built by Tall Agency autonomous build pipeline.
