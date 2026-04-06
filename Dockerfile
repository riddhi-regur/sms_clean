FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl

# 1. MAGIC STEP: Copy Node and NPM from the official Node image
COPY --from=node:20 /usr/local/bin /usr/local/bin
COPY --from=node:20 /usr/local/lib/node_modules /usr/local/lib/node_modules

# 2. Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring zip exif pcntl

# 3. Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Ensure permissions for the 'hot' file and 'public' folder
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www
