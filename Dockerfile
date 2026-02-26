# ---------- Base PHP Apache ----------
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    && docker-php-ext-install mysqli zip \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite module
RUN a2enmod rewrite

# ---------- Install Composer ----------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# -------------------- Optimized Composer Caching --------------------
# 1. Copy composer.json and composer.lock first
COPY composer.json composer.lock* ./

# 2. Copy src/ folder (required for autoload files)
COPY src/ src/

# 3. Install PHP libraries (google/apiclient will be installed automatically)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 4. Copy the rest of the project
COPY . .

# Fix permissions (important for uploads/temp files)
RUN chown -R www-data:www-data /var/www/html

# Expose Apache port
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]