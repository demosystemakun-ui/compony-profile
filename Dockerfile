FROM php:8.4-cli

# Install system dependencies & ekstensi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev unzip libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Mengatur variabel agar composer bisa berjalan dengan lancar di container
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install dependensi PHP tanpa dev
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]