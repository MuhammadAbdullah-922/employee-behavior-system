FROM php:8.2-apache

# Install all required extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install \
    gd \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    xml \
    bcmath \
    opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Setup environment
RUN cp .env.example .env

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Generate app key
RUN php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Configure Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Opcache config for performance
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini

EXPOSE 80

# Start migrations then Apache
CMD php artisan migrate --force && apache2-foreground