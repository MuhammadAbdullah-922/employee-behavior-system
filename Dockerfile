FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip curl \
    && docker-php-ext-install \
    gd pdo pdo_mysql mbstring zip xml bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN cp .env.example .env

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN php artisan key:generate --force

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

COPY docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD php artisan config:clear && \
    php artisan migrate --force && \
    php-fpm -D && \
    nginx -g 'daemon off;'