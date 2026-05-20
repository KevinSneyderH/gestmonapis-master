FROM php:8.2-fpm

# System dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project
COPY . .

# Install dependencies
RUN composer install --no-interaction --prefer-dist

# Permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 storage bootstrap/cache

# Non-root user (Trivy fix DS-0002)
USER www-data

# Healthcheck (Trivy fix DS-0026)
HEALTHCHECK --interval=30s --timeout=10s --start-period=10s --retries=3 \
  CMD php artisan about || exit 1

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000