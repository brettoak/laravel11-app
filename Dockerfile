FROM php:8.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd exif pcntl bcmath opcache intl zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure PHP-FPM
RUN echo "listen = 127.0.0.1:9000" >> /usr/local/etc/php-fpm.d/www.conf

# Configure Nginx
RUN echo 'server {\n\
    listen 80;\n\
    server_name localhost;\n\
    root /var/www/html/public;\n\
    index index.php index.html index.htm;\n\
    \n\
    location / {\n\
    try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    \n\
    location ~ \.php$ {\n\
    fastcgi_pass 127.0.0.1:9000;\n\
    fastcgi_index index.php;\n\
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
    include fastcgi_params;\n\
    }\n\
    \n\
    location ~ /\.ht {\n\
    deny all;\n\
    }\n\
    \n\
    location ~ /\.(?!well-known).* {\n\
    deny all;\n\
    }\n\
    }' > /etc/nginx/sites-available/default

# Enable Nginx site configuration
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Remove default Nginx configuration
RUN rm -f /etc/nginx/sites-enabled/default

# Copy our configuration
RUN cp /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Set Composer environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

# Copy project files
COPY . .

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Create startup script
RUN echo '#!/bin/bash\n\
    # Start PHP-FPM\n\
    php-fpm -D\n\
    # Start 3 queue workers (run in background)\n\
    for i in {1..3}; do\n\
    php artisan queue:work --tries=3 --timeout=90 &\n\
    done\n\
    # Start Nginx (run in foreground to keep container alive)\n\
    nginx -g "daemon off;"' > /start.sh && chmod +x /start.sh

# Expose port
EXPOSE 80

# Start services
CMD ["/start.sh"]

