# 05. Web構築

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. 使用技術

| 項目 | 内容 |
|------|------|
| Webサーバー | Nginx 1.25-alpine |
| アプリケーション | PHP 8.2-FPM-alpine |
| 通信方式 | Nginxがリバースプロキシとしてphp:9000に転送 |

---

## 2. Nginx設定（default.conf）

```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/html;
    index index.php;

    access_log /var/log/nginx/access.log;
    error_log  /var/log/nginx/error.log;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass   php:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

---

## 3. PHP Dockerfile

```dockerfile
FROM php:8.2-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN apk add --no-cache oniguruma-dev && \
    docker-php-ext-install mbstring

COPY custom.ini /usr/local/etc/php/conf.d/custom.ini

RUN addgroup -g 1000 appgroup && \
    adduser -u 1000 -G appgroup -s /bin/sh -D appuser

USER appuser

WORKDIR /var/www/html
```

---

## 4. PHP設定（custom.ini）

```ini
default_charset = "UTF-8"
mbstring.internal_encoding = UTF-8
mbstring.encoding_translation = On
display_errors = Off
log_errors = On
error_reporting = E_ALL
```

---

## 5. 確認結果

| 確認項目 | 結果 |
|---------|------|
| Nginxコンテナ起動 | ✅ 正常 |
| PHPコンテナ起動 | ✅ 正常 |
| Web画面表示 | ✅ 正常 |
| PHP-MySQL接続 | ✅ 正常 |
| 日本語表示 | ✅ 正常 |

---

## 6. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成 | h-kato |
