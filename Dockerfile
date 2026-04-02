FROM php:8.4-fpm

# Install system dependencies (Required for the PHP extensions below)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions (Added pdo_pgsql and removed pdo_mysql)
RUN docker-php-ext-install pdo_pgsql mbstring zip exif pcntl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

