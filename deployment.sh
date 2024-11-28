#!/bin/bash

docker run -d -p 8080:80 -v ./public:/var/www/html php:8.2-apache