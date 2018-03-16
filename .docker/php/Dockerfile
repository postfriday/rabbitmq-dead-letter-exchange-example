FROM php:7.1-fpm
ENV XDEBUGINI_PATH=/usr/local/etc/php/conf.d/xdebug.ini
COPY xdebug.ini /tmp/xdebug.ini
RUN apt-get update \
    && pecl install -o -f xdebug-2.5.0 \
    && docker-php-ext-install mbstring bcmath \
    && rm -rf /tmp/pear \
    && echo "zend_extension="`find /usr/local/lib/php/extensions/ -iname 'xdebug.so'` > $XDEBUGINI_PATH \
    && cat /tmp/xdebug.ini >> $XDEBUGINI_PATH \
    && rm /tmp/xdebug.ini