cat users_dump.sql | docker exec -i SensorianHub_Database /usr/bin/mysql -u root --password=sensorian_root_password SensorianHubSiteDB
cat data_dump.sql | docker exec -i SensorianHub_Database /usr/bin/mysql -u root --password=sensorian_root_password SensorianHubSiteDB
