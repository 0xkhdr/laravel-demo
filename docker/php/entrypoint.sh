#!/bin/sh
set -e

wait_for() {
    local host="$1"
    local port="$2"
    local name="$3"
    echo "Waiting for $name ($host:$port)..."
    while ! nc -z "$host" "$port" 2>/dev/null; do
        sleep 1
    done
    echo "$name is ready."
}

# Install composer dependencies if vendor is missing (development mode)
if [ ! -f "vendor/autoload.php" ]; then
    echo "Installing composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Wait for required services
[ -n "$DB_HOST" ]    && wait_for "$DB_HOST"    "${DB_PORT:-3306}"  "MySQL"
[ -n "$REDIS_HOST" ] && wait_for "$REDIS_HOST" "${REDIS_PORT:-6379}" "Redis"

# Generate application key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force --no-interaction

# Production optimizations
if [ "$APP_ENV" = "production" ]; then
    php artisan optimize
fi

exec "$@"
