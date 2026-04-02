FROM php:8.2-apache

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

RUN a2enmod rewrite headers ssl

COPY custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY security.conf /etc/apache2/conf-available/security.conf
RUN a2enconf security

RUN groupmod -g 1000 www-data && \
    usermod -u 1000 www-data

COPY 000-default-le-ssl.conf /etc/apache2/sites-available/000-default-le-ssl.conf
RUN a2ensite 000-default-le-ssl.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
