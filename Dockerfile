FROM php:8.4-fpm

# Install system dependencies + Nginx
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    nginx

# 1. MAGIC STEP: Copy Node and NPM
COPY --from=node:20 /usr/local/bin /usr/local/bin
COPY --from=node:20 /usr/local/lib/node_modules /usr/local/lib/node_modules

# 2. Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring zip exif pcntl

# 3. Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# 4. Copy everything from your repo
COPY . /var/www

# 5. NEW: Install Node dependencies and Build Vite Assets
RUN npm install && npm run build

# 6. Install composer dependencies
RUN composer install --no-dev --optimize-autoloader

# 7. Fix permissions for Laravel (including the new build folder)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache \
    && mkdir -p /var/www/public/build \
    && chmod -R 775 /var/www/public/build

# 8. Configure Nginx
COPY nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# 9. Setup Startup Script
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Render uses port 10000 by default
EXPOSE 10000

CMD ["/usr/local/bin/start.sh"]
