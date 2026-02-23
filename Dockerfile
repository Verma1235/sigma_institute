# Use official PHP 8.2 image with Apache
FROM php:8.2-apache

# Copy all project files to Apache root
COPY . /var/www/html/

# Enable Apache mod_rewrite (needed for friendly URLs if any)
RUN a2enmod rewrite

# Give execute permission to start.sh
RUN chmod +x /var/www/html/start.sh

# Set working directory
WORKDIR /var/www/html/

# Expose port (Render will map automatically)
EXPOSE 10000

# Run start.sh when container starts
CMD ["./start.sh"]