FROM php:8.1-apache

# Extensions PHP requises par CodeIgniter 4
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install \
        intl \
        mbstring \
        mysqli \
        pdo \
        pdo_mysql \
        zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Activer mod_rewrite pour les URLs CodeIgniter
RUN a2enmod rewrite

# Copier la config Apache
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copier la config PHP
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers du projet
COPY . .

# Installer les dépendances (sans les dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permissions sur writable/
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

EXPOSE 80
