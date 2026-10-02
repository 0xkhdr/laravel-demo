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

# Install composer dependencies if vendor is missing (development mode).
# app and horizon share the vendor volume, so only one container may install it.
install_dependencies() {
    local lock_dir="vendor/.composer-installing"
    local install_marker="vendor/.composer-installed"

    while [ ! -f "$install_marker" ]; do
        if mkdir "$lock_dir" 2>/dev/null; then
            echo "Installing composer dependencies..."
            if composer install --no-interaction --prefer-dist --optimize-autoloader; then
                touch "$install_marker"
                rmdir "$lock_dir"
            else
                rmdir "$lock_dir"
                return 1
            fi
        else
            sleep 1
        fi
    done
}

install_dependencies

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
