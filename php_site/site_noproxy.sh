# Create the database connection file by modifying the example one
sed -e 's/"example_password"/"sensorian_user_password"/g' public_html/dbconnect-docker.php > public_html/dbconnect.php

# Build the site container
sudo docker build -t "sensorianhub_site" .

# Start container without proxy on port 8080 (If unused)
sudo docker run -d -p 8080:80 --name SensorianHub_Site --network=SensorianNet --ip=172.20.0.20 sensorianhub_site:latest
