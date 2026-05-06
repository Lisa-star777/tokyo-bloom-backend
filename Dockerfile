FROM php:8.1-apache

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP расширения для PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath

# Включаем mod_rewrite
RUN a2enmod rewrite

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache Document Root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Копируем код
COPY . /var/www/html/
WORKDIR /var/www/html/

# Ставим зависимости
RUN composer install --no-dev --optimize-autoloader

# Права на папки
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Порт 10000
EXPOSE 10000

# Стартуем Apache
CMD ["apache2-foreground"]