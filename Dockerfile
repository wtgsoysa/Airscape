FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    supervisor

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN php artisan config:cache
RUN php artisan migrate --force
RUN php artisan storage:link

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Nginx configuration
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Supervisor configuration to run Nginx + PHP together
COPY ./docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord"]
