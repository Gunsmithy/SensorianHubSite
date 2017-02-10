# Create the database connection file by modifying the example one
sed -e 's/"example_password"/"sensorian_user_password"/g' public_html/dbconnect-docker.php > public_html/dbconnect.php

# Build the site container
sudo docker build -t "sensorianhub_site" .

# Start nginx proxy and container for hosting with other containers
sudo docker run -d -p 80:80 --net=SensorianNet -v /var/run/docker.sock:/tmp/docker.sock:ro jwilder/nginx-proxy
sudo docker run -d -e VIRTUAL_HOST=sensorianhub.nextproject.ca --name SensorianHub_Site --network=SensorianNet --ip=172.20.0.20 sensorianhub_site:latest
