#!/bin/bash

docker network create --driver bridge --subnet 172.30.0.0/24 --gateway 172.30.0.1 projectmanager-net
docker build -t custom-apache-container .

chmod 666 webAPP/users.json webAPP/user_creation.log

docker run -d --name apache-container --network projectmanager-net -p 8080:80 -v ./webAPP:/var/www/html custom-apache-container
