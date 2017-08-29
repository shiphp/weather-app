# Dockerfile
FROM php:apache

## Install PHP extensions
RUN docker-php-source extract \
    && docker-php-ext-install mysqli \
    && docker-php-source delete
