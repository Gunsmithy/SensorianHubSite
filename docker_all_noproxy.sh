sudo docker network create -d overlay --subnet=172.20.0.0/16 SensorianNet
cd mysql_database
chmod +x docker_mysql.sh
./docker_mysql.sh
cd ..
cd php_site
chmod +x site_noproxy.sh
./site_noproxy.sh
cd ..
