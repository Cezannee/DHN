#!/usr/bin/env bash
# ---------------------------------------------------------------
# Cezanne - one-command project setup
# Usage: bash setup.sh [--demo] [--skip-npm]
# ---------------------------------------------------------------

set -e

echo ""
echo "╔════════════════════════════════════════════════════╗"
echo "║                                                    ║"
echo "║        Cezanne - Project Setup                     ║"
echo "║                                                    ║"
echo "╚════════════════════════════════════════════════════╝"
echo ""

# Install PHP dependencies
echo "→ Installing Composer dependencies..."
composer install --no-interaction --prefer-dist

# Run the interactive Artisan setup wizard (handles .env, DB, migrations, seed, npm)
echo ""
echo "→ Running setup wizard..."
php artisan starter:install "$@"
