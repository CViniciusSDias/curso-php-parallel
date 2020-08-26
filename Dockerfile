FROM php:zts

RUN pecl install parallel
RUN docker-php-ext-enable parallel