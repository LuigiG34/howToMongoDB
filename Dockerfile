FROM php:8.2-cli-alpine

RUN apk add --no-cache autoconf g++ make unzip git \
 && pecl install mongodb \
 && docker-php-ext-enable mongodb

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
CMD ["php", "/app/bin/run.php"]
