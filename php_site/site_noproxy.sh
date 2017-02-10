# Build the site container
sudo docker build -t "sensorianhub_site" .

# Create the database connection file by modifying the example one
sed -e 's/"example_password"/"sensorian_user_password"/g' public_html/dbconnect-docker.php > public_html/dbconnect.php

# Start container without proxy on port 8080 (If unused)
sudo docker run -d -p 8080:80 --link SensorianHub_Database:mysql --name SensorianHub_Site sensorianhub_site:latest
