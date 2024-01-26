# Phase d'exécution
FROM php:8.2-fpm-alpine

COPY . /var/www/html/
WORKDIR /var/www/html/

RUN apk add --no-cache --virtual build-essentials \
    icu-dev icu-libs zlib-dev g++ make automake autoconf libpng libxml2-dev libzip-dev php82-dom php82-session php82-xml php82-zip php82-tokenizer php82-sodium php82-xmlwriter php82-opcache php82-fileinfo \
    libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install pdo && \
    docker-php-ext-install intl && \
    docker-php-ext-install exif && \
    docker-php-ext-install zip

RUN apk add --no-cache composer

RUN composer install --ignore-platform-req=ext-ctype

EXPOSE 8000
