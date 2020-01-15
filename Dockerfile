FROM ubuntu:18.04
ARG DEBIAN_FRONTEND=noninteractive

# Adds PHP* repos
RUN apt-get update -y &&\
    apt-get install -y software-properties-common
RUN apt-add-repository -y ppa:ondrej/php &&\
    apt-get update -y

# Installs PHP 7.2 and it's extensions
RUN apt-get install -y pkg-config git zip php7.3 php7.3-fpm php7.3-cli php7.3-curl php7.3-gd php7.3-json php7.3-mbstring php7.3-mysql php7.3-odbc php7.3-opcache php7.3-pgsql php7.3-readline php7.3-sqlite3 php7.3-xml php7.3-zip php7.3-dev php-memcached php7.3-xdebug php7.3-bcmath
RUN pecl install mongodb
RUN mkdir -p /run/php

RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN chmod +x composer.phar && mv composer.phar /usr/bin/composer

RUN mkdir -p /var/www/service
COPY . /var/www/service
WORKDIR /var/www/service

