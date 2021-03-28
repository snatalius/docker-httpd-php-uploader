FROM php:8-apache
COPY ./public-html/ /var/www/html/
COPY ./php.ini /tmp/
RUN cp "/tmp/php.ini" "$PHP_INI_DIR/"
RUN chown -R www-data: /var/www/html/
USER www-data