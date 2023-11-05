FROM php:8.2-fpm-alpine

# Update app
RUN apk update && apk add --no-cache tzdata
# Set timezone
ENV TZ="Asia/Ho_Chi_Minh"

RUN apk add --update --no-cache autoconf g++ make openssl-dev
RUN apk add libpng-dev
RUN apk add libzip-dev
RUN apk add --update linux-headers

RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
### End Init install

# Install Redis
RUN pecl install redis
RUN docker-php-ext-enable redis


RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
