FROM php:8.3-fpm

# 安装系统依赖与 PHP 扩展
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libfreetype6-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd exif pcntl bcmath opcache

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 设置权限
RUN chown -R www-data:www-data /var/www/html

