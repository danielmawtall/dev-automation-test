FROM php:8.4-apache

LABEL maintainer="Tom Barber"

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/server.crt /etc/apache2/ssl/server.crt
COPY .docker/server.key /etc/apache2/ssl/server.key
COPY .docker/php_custom.ini /usr/local/etc/php/conf.d/php_custom.ini

WORKDIR /var/www

RUN apt-get -qq update -y && apt-get -qq install -y --no-install-recommends \
    git \
    libzip-dev \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    gnupg \
    apt-transport-https \
    libxml2-dev \
    > /dev/null

RUN apt-get update -y && apt-get install -y git zip gnupg apt-transport-https \
    && docker-php-ext-install zip \
    && pecl install xdebug-3.4.0 && docker-php-ext-enable xdebug \
    && PHP_OPENSSL=yes \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install mysqli pdo pdo_mysql gd \
    && chown -R www-data:www-data /var/www \
    && a2enmod rewrite \
    && a2enmod headers \
    && a2enmod ssl

RUN curl -fsSL https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor -o /usr/share/keyrings/yarn-archive-keyring.gpg \
    && echo 'deb [signed-by=/usr/share/keyrings/yarn-archive-keyring.gpg] https://dl.yarnpkg.com/debian/ stable main' | tee /etc/apt/sources.list.d/yarn.list \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - > /dev/null \
    && apt-get update -y && apt-get install -y nodejs yarn > /dev/null

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
