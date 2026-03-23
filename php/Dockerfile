FROM php:8.2-fpm-alpine

# MySQLに接続するための拡張機能をインストール
RUN docker-php-ext-install pdo pdo_mysql mysqli

# mbstringをインストール
RUN apk add --no-cache oniguruma-dev && \
    docker-php-ext-install mbstring

# php.iniをコピー
COPY custom.ini /usr/local/etc/php/conf.d/custom.ini

# 非rootユーザーで実行（セキュリティ対策）
RUN addgroup -g 1000 appgroup && \
    adduser -u 1000 -G appgroup -s /bin/sh -D appuser

USER appuser

WORKDIR /var/www/html