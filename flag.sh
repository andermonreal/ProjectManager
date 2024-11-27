#!/bin/bash

# Crear directorio home de www-data si no existe
mkdir -p /home/www-data

# Generar flag de usuario
USER_FLAG="ssi{$(openssl rand -hex 8)}"
echo $USER_FLAG > /home/www-data/user.txt
chown www-data:www-data /home/www-data/user.txt
chmod 600 /home/www-data/user.txt

# Generar flag de root
ROOT_FLAG="ssi{$(openssl rand -hex 8)}"
echo $ROOT_FLAG > /root/root.txt
chmod 600 /root/root.txt
