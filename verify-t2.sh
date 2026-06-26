#!/bin/bash
# Verification script for T2: Create audit_logs migration

echo "Verifying T2: Create audit_logs migration"
echo "Running: docker exec laravel-demo-app-1 php artisan migrate"
docker exec laravel-demo-app-1 php artisan migrate || exit 1

echo ""
echo "Running: docker exec laravel-demo-app-1 php artisan migrate:rollback"
docker exec laravel-demo-app-1 php artisan migrate:rollback || exit 1

echo ""
echo "Running: docker exec laravel-demo-app-1 php artisan migrate"
docker exec laravel-demo-app-1 php artisan migrate || exit 1

echo ""
echo "✓ All verification steps passed successfully"
exit 0
