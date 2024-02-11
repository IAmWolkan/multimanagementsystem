FROM php:8.3.2-fpm as PHP_BASE

RUN apt-get update && apt-get install -y \
  git \
  unzip \
  libyaml-dev

RUN pecl install yaml \
  && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/ext-yaml.ini \
  && docker-php-ext-enable yaml

RUN docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer
