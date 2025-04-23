#!/bin/bash

echo "Starting Laravel setup..."

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan storage:link

# Start Apache web server
apache2-foreground
