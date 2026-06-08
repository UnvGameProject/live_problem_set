#!/bin/bash
set -e

echo "Running as user: $(whoami)"

# Ownership repair should only run when the container is running as root.
# In this WSL2 setup, phpuser is mapped to the host UID/GID, so runtime chown is unnecessary.
if [ "$(id -u)" = "0" ] && id "phpuser" &>/dev/null; then
    echo "Repairing Laravel writable directory ownership..."
    chown -R phpuser:phpuser /var/www/html/storage /var/www/html/bootstrap/cache
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
else
    echo "Skipping ownership repair because container is not running as root."
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
fi

# Composer install if missing.
if [ ! -d "/var/www/html/vendor" ]; then
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
