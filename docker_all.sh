# git clone https://github.com/sensorian/SensorianHubSite.git && cd SensorianHubSite && chmod +x docker_all.sh && ./docker_all.sh
sudo docker network create --subnet=172.20.0.0/16 SensorianNet
cd mysql_database
chmod +x docker_mysql.sh
chmod +x import.sh
./docker_mysql.sh
cd ..
cd php_site
chmod +x site.sh
./site.sh
cd ..
cd socket_server
chmod +x start.sh
./start.sh
cd ..
