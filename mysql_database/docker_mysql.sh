sudo mkdir -p ~/SensorianHubDatabase
sudo docker run --name SensorianHub_Database --network=SensorianNet --ip=172.20.0.3 -v ~/SensorianHubDatabase:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=sensorian_root_password -e MYSQL_DATABASE=SensorianHubSiteDB -e MYSQL_USER=Sensorian -e MYSQL_PASSWORD=sensorian_user_password -d mysql/mysql-server:latest
cat users_dump.sql | docker exec -i SensorianHub_Database /usr/bin/mysql -u root --password=sensorian_root_password SensorianHubSiteDB
cat data_dump.sql | docker exec -i SensorianHub_Database /usr/bin/mysql -u root --password=sensorian_root_password SensorianHubSiteDB
