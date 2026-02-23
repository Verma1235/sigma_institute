# Use official PHP 8.2 image with Apache
FROM php:8.2-apache

# Install mysqli (MySQL) extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy your project files into Apache root
COPY . /var/www/html/

# Enable Apache mod_rewrite (optional for friendly URLs)
RUN a2enmod rewrite

# Make start.sh executable
RUN chmod +x /var/www/html/start.sh

# Set working directory
WORKDIR /var/www/html/

# Expose port (Render will map automatically)
EXPOSE 10000

# Run start.sh when container starts
CMD ["./start.sh"]