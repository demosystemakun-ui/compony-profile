# 1. Gunakan image Apache (lebih stabil untuk production di Render daripada php-cli)
FROM php:8.5-apache

# 2. Install dependensi sistem dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev unzip libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. COPY FILE PHP.INI ANDA KE DALAM CONTAINER
# Ini akan menimpa settingan default dan mematikan expose_php
COPY php.ini /usr/local/etc/php/conf.d/custom-php.ini

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working directory ke folder public (karena menggunakan Apache)
WORKDIR /var/www/html

# 6. Copy seluruh kode project
COPY . .

# 7. Beri permission untuk folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 9. Konfigurasi Apache: Arahkan document root ke folder /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 10. Aktifkan mod_rewrite untuk Laravel routing
RUN a2enmod rewrite

# 11. Render menggunakan port 8080 secara default, ubah port Apache
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf

# 12. Expose port
EXPOSE 8080

# 13. Jalankan Apache
CMD ["apache2-foreground"]