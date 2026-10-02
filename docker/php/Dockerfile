FROM php:8.3-fpm-alpine AS base

RUN apk add --no-cache \
        curl \
        git \
        libpng-dev \
        libxml2-dev \
        oniguruma-dev \
        zip \
        unzip \
        netcat-openbsd \
        autoconf \
        g++ \
        make \
        linux-headers \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        xml \
        bcmath \
        opcache \
        pcntl \
        sockets \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del autoconf g++ make linux-headers

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]

# Build local frontend assets once during the production image build.
FROM node:22-alpine AS frontend

WORKDIR /var/www/html

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY vite.config.js ./
RUN npm run build

# Production stage — code is baked in, vendor installed without dev deps
FROM base AS production

COPY composer.json composer.lock* ./
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --prefer-dist \
        --no-interaction

COPY . .
COPY --from=frontend /var/www/html/public/build public/build

RUN composer dump-autoload --optimize --classmap-authoritative \
    && touch vendor/.composer-installed \
    && chown -R www-data:www-data storage bootstrap/cache
