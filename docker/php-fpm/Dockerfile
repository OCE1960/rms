FROM php:7.3.11-fpm

RUN apt-get update && apt-get install -y --no-install-recommends\
  apt-utils \
  default-mysql-client \
  libjpeg-dev \
  libpng-dev \
  libfreetype6-dev \ 
  libzip-dev \
  zip \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install pdo_mysql gd zip bcmath