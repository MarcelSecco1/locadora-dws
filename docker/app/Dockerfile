FROM php:8.4-fpm-bookworm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
        curl \
        git \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        unzip \
        zip \
    && docker-php-ext-install pdo_mysql mbstring intl zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=node:22-bookworm /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-bookworm /usr/local/bin/npm /usr/local/bin/npm
COPY --from=node:22-bookworm /usr/local/bin/npx /usr/local/bin/npx
COPY --from=node:22-bookworm /usr/local/lib/node_modules /usr/local/lib/node_modules

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN ln -sf /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -sf /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

RUN mkdir -p /var/www/html/public/build

COPY composer.json composer.lock package.json package-lock.json ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts
RUN npm install

COPY . .
RUN php artisan package:discover --ansi
RUN npm run build
RUN php artisan storage:link --force || true
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && cp -a public/build /opt/public-build \
    && chown -R www-data:www-data storage bootstrap/cache /opt/public-build

COPY docker/app/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
