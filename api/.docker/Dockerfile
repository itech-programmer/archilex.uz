FROM php:8.4-fpm-alpine AS base

ENV COMPOSER_ALLOW_SUPERUSER=1

# System deps
RUN apk add --no-cache \
    libpq-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libxml2-dev \
    curl-dev \
    zip \
    unzip \
    git \
    $PHPIZE_DEPS

# PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    pdo_pgsql \
    pgsql \
    bcmath \
    intl \
    opcache \
    zip \
    mbstring \
    xml \
    pcntl

# Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# ------------------------
# Dev target
# ------------------------
FROM base AS dev

# Copy only composer files first (better cache)
COPY composer.json composer.lock ./

# IMPORTANT:
# --no-scripts чтобы не запускался artisan package:discover во время build
RUN composer install --no-interaction --prefer-dist --no-progress --no-scripts

# Copy project
COPY . .

# Permissions (Laravel)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
