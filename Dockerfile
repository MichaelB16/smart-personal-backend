FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    libpq-dev && \
    docker-php-ext-install pdo_mysql gd pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

EXPOSE 9000

CMD ["php-fpm"]

# CMD ["artisan", "serve", "--host=0.0.0.0", "--port=8080"]
