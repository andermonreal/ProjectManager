#!/bin/bash

docker build -t project_manager .
docker run -d -p 8080:80 -v ./public:/usr/local/apache2/htdocs/ project_manager