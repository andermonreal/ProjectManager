#!/bin/bash

docker stop apache-container
docker rm apache-container
docker rmi custom-apache-container:latest
docker build -t custom-apache-container .
docker run -d --name apache-container -p 8080:80 -v ./webAPP:/var/www/html custom-apache-container