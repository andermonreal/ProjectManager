#!/bin/bash

if [ "$UID" -ne 0 ]; then
    echo "This script must be run as root."
    exit 1
fi

apt update
apt install apache2 git php gcc -y

systemctl enable apache2

git clone https://github.com/andermonreal/ProjectManager

cp ./ProjectManager/webApp/ /var/www/html/
chown www-data /var/www/html/* -R


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

echo 'ssi{$(openssl rand -hex 8)}' > /home/www-data/user.txt
chown www-data:www-data /home/www-data/user.txt
chmod 600 /home/www-data/user.txt

echo 'ssi{$(openssl rand -hex 8)}' > /root/root.txt
chmod 600 /root/root.txt

gcc -fno-stack-protector -z execstack -o /home/www-data/rootAuth /home/www-data/rootAuth.c
chmod u+s /home/www-data/rootAuth" > /usr/local/bin/flagsGen.sh

chmod +x /usr/local/bin/flagsGen.sh
systemctl enable flagsGen.service