FROM php:8.3-fpm

# 安装系统依赖和 PHP 扩展
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    zip \
    unzip \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd exif pcntl bcmath opcache intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 配置 PHP-FPM
RUN echo "listen = 127.0.0.1:9000" >> /usr/local/etc/php-fpm.d/www.conf

# 配置 Nginx
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

# 启用 Nginx 站点配置
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# 移除默认的 Nginx 配置
RUN rm -f /etc/nginx/sites-enabled/default

# 复制我们的配置
RUN cp /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# 设置工作目录
WORKDIR /var/www/html

# 设置权限
RUN chown -R www-data:www-data /var/www/html

# 创建启动脚本
RUN echo '#!/bin/bash\n\
# 启动 PHP-FPM\n\
php-fpm -D\n\
# 启动 Nginx\n\
nginx -g "daemon off;"' > /start.sh && chmod +x /start.sh

# 暴露端口
EXPOSE 80

# 启动服务
CMD ["/start.sh"]

