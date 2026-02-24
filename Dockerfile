# Trigger Build v7
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
    dos2unix \
    && docker-php-ext-install pdo_mysql pdo_sqlite bcmath gd mbstring \
    && rm -rf /var/lib/apt/lists/*

# Definitive Fix for Apache MPM configuration
RUN rm -f /etc/apache2/mods-enabled/mpm_* \
    && a2dismod mpm_event mpm_worker 2>/dev/null || true \
    && a2enmod mpm_prefork rewrite

# Set working directory
WORKDIR /var/www/html

# Set ServerName to avoid warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy the application code
COPY . /var/www/html/

# Ensure .env exists from example
RUN cp .env.example .env

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create necessary directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache/data} \
    && mkdir -p database \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Robust Apache Configuration
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
    Options -Indexes +FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>\n\
    </VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Set environment variables
ENV PORT=8080
EXPOSE 8080

# Convert line endings and make entrypoint executable
RUN dos2unix /var/www/html/entrypoint.sh \
    && chmod +x /var/www/html/entrypoint.sh

# Start using entrypoint
ENTRYPOINT ["/var/www/html/entrypoint.sh"]
