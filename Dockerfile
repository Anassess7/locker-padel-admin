# Use the official PHP image with required extensions
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    libzip-dev npm nodejs libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy package files first
COPY package*.json ./
COPY vite.config.js ./

# Install Node.js dependencies
RUN npm install

# Copy the rest of the application
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build assets
RUN npm run build && \
    ls -la public/build/ && \
    cat public/build/manifest.json

# Laravel permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/public/build

# Expose port
EXPOSE 8000

# Start Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
