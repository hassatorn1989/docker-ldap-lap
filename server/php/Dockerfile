FROM php:8.3-fpm

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libldap2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql ldap

COPY custom-php.ini /usr/local/etc/php/php.ini

RUN usermod -u 1000 www-data

WORKDIR /var/www/html