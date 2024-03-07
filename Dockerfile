# Utilisation d'une image PHP-FPM
FROM php:8.2-apache

# Installation des dépendances nécessaires
RUN apt-get update \
    && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    libicu-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install -j$(nproc) zip pdo_mysql intl gd

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Création d'un répertoire de travail et copie du code source
WORKDIR /var/www/html
COPY . .

RUN chmod -R 777 *

# Installation des dépendances PHP via Composer
RUN composer install --no-scripts --no-autoloader

# Chargement de l'autoloader de Composer
RUN composer dump-autoload --optimize

# Exposition du port 9000 pour PHP-FPM
EXPOSE 80
