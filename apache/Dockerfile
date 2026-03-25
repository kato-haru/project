FROM php:8.2-apache

# 必要な拡張機能をインストール
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    mbstring \
    zip

# Apacheのmod_rewriteを有効化（.htaccess用）
RUN a2enmod rewrite

# php.iniの設定
COPY custom.ini /usr/local/etc/php/conf.d/custom.ini

# 非rootユーザーで実行
RUN groupmod -g 1000 www-data && \
    usermod -u 1000 www-data

WORKDIR /var/www/html