# git clone https://github.com/sensorian/SensorianHubSite.git --branch Dockerization --single-branch && cd SensorianHubSite && chmod +x docker_all_noproxy.sh && ./docker_all_noproxy.sh
sudo docker network create --subnet=172.20.0.0/16 SensorianNet
cd mysql_database
chmod +x docker_mysql.sh
./docker_mysql.sh
chmod +x import.sh
./import.sh
cd ..
cd php_site
chmod +x site_noproxy.sh
./site_noproxy.sh
cd ..
