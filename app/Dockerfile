FROM php:7-fpm

WORKDIR /app

COPY . .

RUN docker-php-ext-install mysqli pdo pdo_mysql

ENV MYSQL_HOST=db

ENV MYSQL_USERNAME=admin

ENV MYSQL_PASSWORD=pass

ENV REDIS_HOST=redis

