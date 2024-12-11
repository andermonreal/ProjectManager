#!/bin/bash

if [ "$UID" -ne 0 ]; then
    echo "This script must be run as root."
    exit 1
fi

apt update
apt install apache2 git php gcc -y

systemctl enable apache2
mkdir -p /home/www-data

git clone https://github.com/andermonreal/ProjectManager

cp /home/user1/ProjectManager/webAPP/* /var/www/html/ -r
cp /home/user1/ProjectManager/rootAuth.c /home/www-data/
chown www-data /var/www/html/* -R
chown www-data /home/www-data -R


echo "[Unit]
Description=Ejecutar mi script personalizado al iniciar
After=multi-user.target

[Service]
ExecStart=/usr/local/bin/flagsGen.sh
Type=oneshot

[Install]
WantedBy=multi-user.target" > /etc/systemd/system/flagsGen.service



cp /home/user1/ProjectManager/flagsGen.sh /usr/local/bin/
chmod +x /usr/local/bin/flagsGen.sh
systemctl enable flagsGen.service