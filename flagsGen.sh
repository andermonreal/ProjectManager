#!/bin/bash

mkdir -p /home/www-data

USER_FLAG="ssi{$(openssl rand -hex 8)}"
echo $USER_FLAG > /home/www-data/user.txt
chown www-data:www-data /home/www-data/user.txt
chmod 600 /home/www-data/user.txt

ROOT_FLAG="ssi{$(openssl rand -hex 8)}"
echo $ROOT_FLAG > /root/root.txt
chmod 600 /root/root.txt

gcc -fno-stack-protector -z execstack -o /home/www-data/rootAuth /home/www-data/rootAuth.c
chmod u+s /home/www-data/rootAuth
