#!/bin/bash
set -e

echo "--- Starting Entrypoint Script ---"

# Set up port dynamically for Railway
echo "Configuring Apache port to ${PORT:-8080}..."
sed -i "s/Listen 80/Listen ${PORT:-8080}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT:-8080}>/g" /etc/apache2/sites-available/000-default.conf

# Ensure .env exists
if [ ! -f .env ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
fi

# Ensure APP_KEY exists
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating app key..."
    php artisan key:generate --force
fi

# Set up database (SQLite fallback)
if [ ! -f database/database.sqlite ]; then
    echo "Creating database/database.sqlite..."
    mkdir -p database
    touch database/database.sqlite
fi

echo "Running migrations..."
php artisan migrate --force || echo "WARNING: Migration failed, continuing to start server..."

echo "Caching configuration and routes..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Final permissions check
echo "Applying file permissions..."
chmod -R 775 storage bootstrap/cache database
chown -R www-data:www-data /var/www/html

echo "Starting Apache..."
exec apache2-foreground
