# Use the official PHP image with required extensions
FROM php:8.2-fpm

# Install system dependencies and Node.js
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    libzip-dev nodejs npm libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy only package files to install npm deps first (to cache better)
COPY package*.json ./
RUN npm install

# Copy the full app
COPY . .

# Build Vite assets
RUN npm run build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set Laravel permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public/build

# Expose port
EXPOSE 8000

# Start Laravel dev server (you can switch to php-fpm and Nginx in production)
CMD php artisan serve --host=0.0.0.0 --port=8000
