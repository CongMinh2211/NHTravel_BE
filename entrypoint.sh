#!/bin/sh

# Create database file if doesn't exist
touch /app/database/database.sqlite

# Run migrations and seeders
php artisan migrate --force
# php artisan db:seed --force # Tạm thời comment seed để tránh lỗi trùng lặp khi restart

# Start the server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
