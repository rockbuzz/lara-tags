FROM php:8.0-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS bash

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

ENTRYPOINT ["php-fpm"]