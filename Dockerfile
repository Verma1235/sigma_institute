# ---------- Base PHP Apache ----------
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    && docker-php-ext-install mysqli zip \
    && rm -rf /var/lib/apt/lists/*

# Fix Apache port for Render (Default 80 -> 10000)
RUN sed -i 's/80/10000/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Enable Apache rewrite module
RUN a2enmod rewrite

# ---------- Install Composer ----------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# ---------- Optimized Build ----------
# 1. Copy composer files
COPY composer.json composer.lock* ./

# 2. Install dependencies (creates /vendor)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 3. Copy the rest of the project
COPY . .

# 4. Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 10000

CMD ["apache2-foreground"]