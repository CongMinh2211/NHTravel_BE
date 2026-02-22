FROM php:8.2-cli

# Install system dependencies + SQLite
RUN apt-get update && apt-get install -y \
    git zip unzip libsqlite3-dev libpng-dev \
    && docker-php-ext-install pdo_sqlite bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create storage directories & set permissions
RUN mkdir -p storage/framework/{sessions,views,cache/data} \
    && mkdir -p database \
    && chmod -R 775 storage bootstrap/cache database

EXPOSE 8080

# At startup: create SQLite DB, run migrations, seed, then serve
CMD touch database/database.sqlite && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
