sudo mkdir -p ~/SensorianHubDatabase
sudo docker run --name SensorianHub_Database -v ~/SensorianHubDatabase:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=sensorian_root_password -e MYSQL_DATABASE=SensorianHubDB -e MYSQL_USER=Sensorian -e MYSQL_PASSWORD=sensorian_user_password -d mysql/mysql-server:latest
sudo docker exec -i SensorianHub_Database mysql -u=root -p=sensorian_root_password < users_dump.sql
sudo docker exec -i SensorianHub_Database mysql -u=root -p=sensorian_root_password < data_dump.sql
