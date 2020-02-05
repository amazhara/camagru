FROM php:7.2.27-apache-stretch

RUN a2enmod rewrite
RUN apt-get update && apt-get install -y ssmtp && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql mysqli

ADD ssmtp.conf /etc/ssmtp/ssmtp.conf
ADD php-smtp.ini /usr/local/etc/php/conf.d/php-smtp.ini
