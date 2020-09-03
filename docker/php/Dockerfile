FROM php:7.4-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt install -y unzip \
    && apt-get clean
RUN cd /usr/src \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer