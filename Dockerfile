FROM php:8.3-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load
