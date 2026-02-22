#!/bin/sh

echo "--- Starting Entrypoint Script (Debug version) ---"

# Debug env
echo "Current PORT: ${PORT}"

# Đảm bảo thư mục storage ghi được
chmod -R 777 /app/storage
chmod -R 777 /app/bootstrap/cache

echo "Running migrations..."
# Chạy migrate --force để cập nhật DB cấu trúc mới (không mất dữ liệu cũ)
php artisan migrate --force || echo "Migration failed, continuing anyway..."

echo "Checking if database needs seeding..."
USER_COUNT=$(php artisan tinker --execute="echo App\Models\NguoiDung::count();")
if [ "$USER_COUNT" = "0" ]; then
    echo "Database is empty. Seeding initial data..."
    php artisan db:seed --force
else
    echo "Database already has data ($USER_COUNT users). Skipping seed."
fi

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
