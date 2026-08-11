#!/bin/bash

docker stop apache-container
docker rm apache-container
docker network rm projectmanager-net
docker rmi custom-apache-container:latesti

