# ---------- Base PHP Apache ----------
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    && docker-php-ext-install mysqli zip

# Enable Apache rewrite
RUN a2enmod rewrite

# ---------- Install Composer ----------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy only composer files first (Docker cache optimization)
COPY composer.json composer.lock* ./

# Install PHP libraries (THIS WILL INSTALL google/apiclient automatically)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy rest of project
COPY . .

# Fix permissions (important for uploads/temp files)
RUN chown -R www-data:www-data /var/www/html

# Expose render port
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]