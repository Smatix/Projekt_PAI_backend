FROM php:7.3-apache

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath && a2enmod rewrite && apt-get install -y screen

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
       mv composer.phar /usr/local/bin/composer

COPY apache.conf /etc/apache2/sites-enabled/000-default.conf