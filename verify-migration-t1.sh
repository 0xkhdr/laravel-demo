#!/bin/bash
# Verification script for T1 migration
# This script runs the migration verification cycle using docker-compose

set -e

cd /var/www/html/rai/up/laravel-demo

echo "=== Step 1: Running migrations ==="
docker-compose exec -T app php artisan migrate 2>&1 | grep -E "(DONE|FAIL|INFO)"

echo "=== Step 2: Rolling back migrations ==="
docker-compose exec -T app php artisan migrate:rollback 2>&1 | grep -E "(DONE|FAIL|INFO)"

echo "=== Step 3: Running migrations again ==="
docker-compose exec -T app php artisan migrate 2>&1 | grep -E "(DONE|FAIL|INFO)"

echo "=== Verification complete ==="
exit 0
