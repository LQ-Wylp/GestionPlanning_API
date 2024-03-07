# Utilisation d'une image PHP-FPM
FROM php:8.2-fpm

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

# Installation des dépendances PHP via Composer
RUN composer install --no-scripts --no-autoloader

# Chargement de l'autoloader de Composer
RUN composer dump-autoload --optimize

# Définir les permissions des fichiers 
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html/var

# Exposition du port 9000 pour PHP-FPM
EXPOSE 9000

# Commande à exécuter lors du démarrage du conteneur
CMD ["php-fpm"]
