#!/bin/sh
set -e

cd /var/www/html

if [ "$(id -u)" = "0" ]; then
    mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache/data storage/logs bootstrap/cache
    chmod -R ug+rwx storage bootstrap/cache || true
fi

# Bind-mounted repo can carry stale bootstrap/cache from the host; vendor may differ (e.g. Docker
# named volume from `composer install --no-dev`). Drop generated manifests so discovery matches
# the actual vendor tree.
if [ -f artisan ]; then
    rm -f bootstrap/cache/packages.php bootstrap/cache/services.php
    php artisan package:discover --ansi --no-interaction || echo "warning: package:discover failed; continuing (bootstrap cache may be stale)"
fi

if [ "$(id -u)" = "0" ]; then
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R ug+rwx storage bootstrap/cache
fi

exec "$@"
