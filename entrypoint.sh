#!/bin/sh

service php7.2-fpm start
nginx -g "daemon off;"
python /home/www/modules/ntkl.py