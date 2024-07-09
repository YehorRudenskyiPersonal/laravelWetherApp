#!/bin/sh
php-fpm &

php artisan queue:work --queue=default &

# Start cron service
service cron start

# Tail the cron log file to keep the container running
tail -f /var/log/cron.log
