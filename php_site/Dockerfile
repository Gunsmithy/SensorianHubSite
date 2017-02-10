# Build from the official PHP Docker image containing Apache
FROM php:apache

# I am the maintainer - Dylan Kauling
MAINTAINER dylan.kauling@uoit.net

# Copy the website code into the Docker container
COPY public_html/ /var/www/html/

# Install the MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 80 for HTTP and 443 for HTTPS traffic
EXPOSE 80 443

# Helper commands to run the builds and start the containers

# Build Container
# docker build -t "sensorianhub_site" .

# Start container without proxy
# docker run -d -p 80:80 --link SensorianHub_Database:mysql --name SensorianHub_Site sensorianhub_site:latest

# Start nginx proxy and container for hosting with other containers
# docker run -d -p 80:80 -v /var/run/docker.sock:/tmp/docker.sock:ro jwilder/nginx-proxy
# docker run -d --link SensorianHub_Database:mysql -e VIRTUAL_HOST=sensorianhub.nextproject.ca --name SensorianHub_Site sensorianhub_site:latest
