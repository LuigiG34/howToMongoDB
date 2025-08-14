FROM php:8.2-cli-alpine

RUN apk add --no-cache autoconf g++ make \
 && pecl install mongodb \
 && docker-php-ext-enable mongodb \
 && apk del autoconf g++ make

WORKDIR /app
CMD ["php", "/app/bin/run.php"]