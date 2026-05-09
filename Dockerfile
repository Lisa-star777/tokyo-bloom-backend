FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    zip \
    xml

RUN a2enmod rewrite headers

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Настройка CORS на уровне Apache
RUN echo '<IfModule mod_headers.c>\n\
    SetEnvIf Origin "^https://tokyo-bloom.onrender.com$" CORS_ALLOW=$0\n\
    SetEnvIf Origin "^http://localhost:5173$" CORS_ALLOW=$0\n\
    Header always set Access-Control-Allow-Origin "%{CORS_ALLOW}e" env=CORS_ALLOW\n\
    Header always set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS, PATCH"\n\
    Header always set Access-Control-Allow-Headers "Content-Type, Authorization, X-Requested-With, Accept, X-XSRF-TOKEN"\n\
    Header always set Access-Control-Allow-Credentials "true"\n\
    Header merge Vary Origin\n\
    </IfModule>' > /etc/apache2/conf-available/cors.conf

RUN a2enconf cors

COPY . /var/www/html/
WORKDIR /var/www/html/

RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts

RUN php artisan config:clear
RUN php artisan cache:clear

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 10000

CMD ["apache2-foreground"]
