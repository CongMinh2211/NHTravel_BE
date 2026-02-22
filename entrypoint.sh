#!/bin/sh

echo "--- Starting Entrypoint Script (Debug version) ---"

# Debug env
echo "Current PORT: ${PORT}"

# Đảm bảo thư mục database tồn tại và ghi được
mkdir -p /app/database
touch /app/database/database.sqlite
chmod -R 777 /app/database
chmod -R 777 /app/storage
chmod -R 777 /app/bootstrap/cache

echo "Running migrations..."
php artisan migrate --force || echo "Migration failed, continuing anyway..."

echo "Seeding database..."
php artisan db:seed --force || echo "Seeder failed (maybe already seeded), continuing..."

# Kiểm tra file log nếu có lỗi
touch /app/storage/logs/laravel.log
chmod 777 /app/storage/logs/laravel.log

# Clear và optimize Laravel
php artisan config:clear
php artisan cache:clear
php artisan route:clear

echo "Starting Laravel Server on port ${PORT:-8000}..."
# Trở về dùng artisan serve để đúng chuẩn Laravel
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
