ARG PHP_VERSION=8.1.7

FROM composer:latest AS builder

WORKDIR /build

COPY ./composer.json .
COPY ./composer.lock .
COPY .env .
COPY artisan .
COPY ./bootstrap ./bootstrap
COPY ./routes ./routes
COPY ./config ./config
COPY ./resources ./resources
COPY ./storage ./storage
COPY ./database ./database
COPY ./app ./app

RUN chmod -R 777 ./storage

RUN composer install --ignore-platform-reqs

FROM php:${PHP_VERSION}-cli AS php-cli

FROM php:${PHP_VERSION}-fpm

# Add `www-data` to group `appuser`
RUN addgroup --gid 1000 appuser
RUN adduser --uid 1000 --gid 1000 --disabled-password appuser
RUN adduser www-data appuser

RUN apt update && apt install -y libicu-dev && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y --no-install-recommends\
  apt-utils \
  default-mysql-client \
  libjpeg-dev \
  libpng-dev \
  libfreetype6-dev \
  libzip-dev \
  zip \
  dialog \
  && pecl install pcov \
  && mkdir -p /usr/share/man/man1 \
  && echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections \
  && apt-get install pdftk-java -y --no-install-recommends -q \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-configure zip \
  && docker-php-ext-install pdo_mysql gd zip bcmath \
  && docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install pcntl \
  && docker-php-ext-configure intl \
  && docker-php-ext-install  intl \
  && docker-php-ext-enable intl \
  && docker-php-ext-enable pcov \
  && apt-get update && apt-get install -y --no-install-recommends supervisor

WORKDIR /var/www/rms

#Restoring the phpdbg
COPY --from=php-cli /usr/local/bin/phpdbg /usr/local/bin/
COPY --from=builder /build/vendor ./vendor
COPY --from=builder /usr/bin/composer /usr/bin/composer

# Allows larger files, i.e employee uploads, to be uploaded via Nova.
RUN printf '%s\n' 'upload_max_filesize = 10M' 'post_max_size = 10M' 'memory_limit = 2048M' > /usr/local/etc/php/conf.d/docker-php-increase-post-size.ini

# Allows PHP FPM to hold more request threads and servers, thus decrease Nova page load times locally.
RUN printf '%s\n' 'pm.max_children = 20' 'pm.start_servers = 5' 'pm.min_spare_servers = 5' 'pm.max_spare_servers = 10' >> /usr/local/etc/php-fpm.d/www.conf

