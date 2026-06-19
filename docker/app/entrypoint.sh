#!/bin/sh
set -eu

if [ ! -f /var/www/html/public/build/manifest.json ]; then
    mkdir -p /var/www/html/public/build
    cp -a /opt/public-build/. /var/www/html/public/build/
fi

mkdir -p /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

php artisan optimize:clear >/dev/null 2>&1 || true
php artisan permission:cache-reset >/dev/null 2>&1 || true

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R ug+rwX /var/www/html/storage /var/www/html/bootstrap/cache

exec "$@"
