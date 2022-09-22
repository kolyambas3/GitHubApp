FROM php:8.1.9-fpm AS php
WORKDIR /app
RUN docker-php-ext-install pdo pdo_mysql mysqli
EXPOSE 9000