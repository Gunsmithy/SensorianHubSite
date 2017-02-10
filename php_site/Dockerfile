# Build from the official PHP Docker image containing Apache
FROM php:apache

# I am the maintainer - Dylan Kauling
MAINTAINER dylan.kauling@uoit.net

# Copy the website code into the Docker container
COPY public_html/ /var/www/html/

# Install the MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql mysql mysqli

# Expose port 80 for HTTP and 443 for HTTPS traffic
EXPOSE 80 443
