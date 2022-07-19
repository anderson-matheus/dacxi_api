FROM php:8.0-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql mysqli
 
COPY crontab /etc/crontabs/root

CMD ["crond", "-f"]