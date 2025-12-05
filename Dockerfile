FROM php:8.2-alpine

# Установите системные пакеты
RUN apk update && apk add --no-cache \
    curl \
    git \
    unzip \
    postgresql-dev \
    libzip-dev \
    && echo "opcache.enable=0" > /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.enable_cli=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Установите расширения PHP для PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql zip

# Установите Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Настройка рабочей директории
WORKDIR /var/www/html

# Копирование кода приложения
COPY . .

# Установите зависимости Laravel
RUN composer install --no-interaction --optimize-autoloader

# Откройте порт
EXPOSE 8000

# Команда запуска
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
