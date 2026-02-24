# Trigger Build v3
FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libsqlite3-dev \
    libpng-dev \
    libmariadb-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql pdo_sqlite bcmath gd mbstring \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Set ServerName to avoid warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy the application code
# Note: When pushed to NHTravel_BE repo, the contents of the 'be' folder will be at root
COPY . /var/www/html/

# Copy .env file if exists (Railway usually provides env vars, but just in case)
COPY .env.example .env

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create necessary directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache/data} \
    && mkdir -p database \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Configure Apache
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && echo "<Directory /var/www/html/public>" > /etc/apache2/sites-available/000-default.conf \
    && echo "    Options -Indexes +FollowSymLinks" >> /etc/apache2/sites-available/000-default.conf \
    && echo "    AllowOverride All" >> /etc/apache2/sites-available/000-default.conf \
    && echo "    Require all granted" >> /etc/apache2/sites-available/000-default.conf \
    && echo "</Directory>" >> /etc/apache2/sites-available/000-default.conf

# Set environment variables for Railway
ENV PORT=8080
EXPOSE 8080

# Use the PORT environment variable in Apache config
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Start Apache
RUN chmod +x /var/www/html/entrypoint.sh
ENTRYPOINT ["/var/www/html/entrypoint.sh"]
