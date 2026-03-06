#!/bin/bash
set -e

echo "Running as user: $(whoami)"

# Only run PHP/Laravel-specific setup if phpuser exists (i.e. in the app container)
if id "phpuser" &>/dev/null; then
    chown -R phpuser:phpuser /var/www/html/storage /var/www/html/bootstrap/cache
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

    if [ -d "/var/www/html/node_modules" ]; then
        chown -R phpuser:phpuser /var/www/html/node_modules
    fi
fi

# Composer install if missing (app container only)
if id "phpuser" &>/dev/null && [ ! -d "/var/www/html/vendor" ]; then
    echo "📦 Installing composer dependencies..."
    composer install --no-interaction --prefer-dist
fi

case "$1" in
  php-fpm)
    echo "📦 Starting PHP-FPM..."
    exec php-fpm
    ;;
  *)
    exec "$@"
    ;;
esac
