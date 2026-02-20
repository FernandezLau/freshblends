# Use official PHP Apache image
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install required PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    mysql-client \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Configure Apache DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/webroot|g' /etc/apache2/sites-available/000-default.conf

# Create .htaccess for CakePHP routing
RUN echo '<Directory /var/www/html/webroot>' > /var/www/html/webroot/.htaccess && \
    echo 'RewriteEngine On' >> /var/www/html/webroot/.htaccess && \
    echo 'RewriteCond %{REQUEST_FILENAME} !-f' >> /var/www/html/webroot/.htaccess && \
    echo 'RewriteCond %{REQUEST_FILENAME} !-d' >> /var/www/html/webroot/.htaccess && \
    echo 'RewriteRule ^ index.php [L]' >> /var/www/html/webroot/.htaccess && \
    echo '</Directory>' >> /var/www/html/webroot/.htaccess

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
