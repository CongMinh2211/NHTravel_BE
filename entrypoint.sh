#!/bin/sh

echo "--- Starting Entrypoint Script ---"

# Set up environment
echo "Running migrations..."
php artisan migrate --force

echo "Caching configuration and routes..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions again just in case
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data /var/www/html

echo "Starting Apache..."
exec apache2-foreground
