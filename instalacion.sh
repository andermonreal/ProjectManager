echo "#!/bin/bash

sudo su
apt update
apt install apache2 git php -y
systemctl enable apache2

echo "[Unit]
Description=Ejecutar mi script personalizado al iniciar
After=multi-user.target

[Service]
ExecStart=/usr/local/bin/flagsGen.sh
Type=oneshot

[Install]
WantedBy=multi-user.target" > /etc/systemd/system/flagsGen.service

echo "#!/bin/bash

mkdir -p /home/www-data

USER_FLAG="ssi{$(openssl rand -hex 8)}"
echo $USER_FLAG > /home/www-data/user.txt
chown www-data:www-data /home/www-data/user.txt
chmod 600 /home/www-data/user.txt

ROOT_FLAG="ssi{$(openssl rand -hex 8)}"
echo $ROOT_FLAG > /root/root.txt
chmod 600 /root/root.txt" > /usr/local/bin/flagsGen.sh

chmod +x /usr/local/bin/flagsGen.sh
systemctl enable flagsGen.service