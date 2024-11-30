FROM ubuntu:latest

RUN apt update && apt install -y \
    apache2 \
    php \
    gcc \
    systemd \
    openssl \
    && apt clean


COPY rootAuth.c /home/www-data/rootAuth.c

RUN mkdir -p /home/www-data && \
    echo "ssi{$(openssl rand -hex 8)}" > /home/www-data/user.txt && \
    chown www-data:www-data /home/www-data/user.txt && \
    chmod 600 /home/www-data/user.txt && \
    echo "ssi{$(openssl rand -hex 8)}" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    rm -rf /home/ubuntu

RUN gcc -fno-stack-protector -z execstack -o /home/www-data/rootAuth /home/www-data/rootAuth.c && \
    chmod u+s /home/www-data/rootAuth

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]