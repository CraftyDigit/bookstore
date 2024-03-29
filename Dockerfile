FROM php:8.2.0-apache

RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql  &&  \
    docker-php-ext-enable pdo_mysql 

RUN a2enmod rewrite
    