sudo mkdir -p ~/SensorianHubDatabase
sudo docker run -d --name=SensorianHub_Database --network=SensorianNet --ip=172.20.0.30 -v ~/SensorianHubDatabase:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=sensorian_root_password -e MYSQL_DATABASE=SensorianHubSiteDB -e MYSQL_USER=Sensorian -e MYSQL_PASSWORD=sensorian_user_password mysql/mysql-server:latest
