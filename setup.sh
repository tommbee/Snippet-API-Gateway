#!/bin/sh
if [ -n "$CHOWN_TO_USER" ]; then chown -R $CHOWN_TO_USER /app; fi

/bin/echo clear_env = no >> /etc/php/7.0/fpm/pool.d/www.conf
/usr/sbin/php-fpm7.0
/usr/sbin/nginx -g 'daemon off;'