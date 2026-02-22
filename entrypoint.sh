#!/bin/sh
set -e

echo "--- Starting Entrypoint Script ---"

# Đảm bảo thư mục database tồn tại
mkdir -p /app/database

# Tạo file database nếu chưa có
if [ ! -f /app/database/database.sqlite ]; then
    echo "Creating database.sqlite..."
    touch /app/database/database.sqlite
fi

echo "Setting permissions..."
chmod -R 777 /app/storage /app/bootstrap/cache /app/database

echo "Running migrations..."
php artisan migrate --force

echo "Starting PHP Server on port ${PORT:-8080}..."
# Sử dụng php -S thay cho artisan serve để ổn định hơn trong container
exec php -S 0.0.0.0:${PORT:-8080} -t public
