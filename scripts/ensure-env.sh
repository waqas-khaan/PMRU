#!/bin/sh
# Restore .env from .env.example if missing (e.g. after clone or merge).
# Run manually: ./scripts/ensure-env.sh
# Or from repo root: sh scripts/ensure-env.sh
cd "$(dirname "$0")/.." || exit 1
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
        echo "Created .env from .env.example. Run: php artisan key:generate"
        echo "Then set DB_*, APP_URL, and other values in .env"
    else
        echo "No .env.example found." && exit 1
    fi
else
    echo ".env already exists (unchanged)."
fi
