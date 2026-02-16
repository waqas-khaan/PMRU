#!/bin/sh
# Make bootstrap/cache and storage writable by all so any developer can edit/run without permission errors.
# Run from repo root: sh scripts/fix-permissions.sh
cd "$(dirname "$0")/.." || exit 1
mkdir -p bootstrap/cache storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
chmod -R 777 bootstrap/cache storage
echo "Done: bootstrap/cache and storage are now writable by all."
