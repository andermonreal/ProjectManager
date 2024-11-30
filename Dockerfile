FROM ubuntu:latest

RUN apt update && apt install -y \
    apache2 \
    php \
    gcc \
    systemd \
    && apt clean

COPY flagsGen.sh /usr/local/bin/flagsGen.sh

RUN echo '#include <stdio.h>\n#include <stdlib.h>\nint main() { printf("Root Auth Program\\n"); return 0; }' > /home/www-data/rootAuth.c

RUN chmod +x /usr/local/bin/flagsGen.sh && \
    chown www-data:www-data /home/www-data -R && \
    chmod 600 /home/www-data/*

RUN echo "[Unit]\n\
    Description=Ejecutar mi script personalizado al iniciar\n\
    After=multi-user.target\n\n\
    [Service]\n\
    ExecStart=/usr/local/bin/flagsGen.sh\n\
    Type=oneshot\n\n\
    [Install]\n\
    WantedBy=multi-user.target" > /etc/systemd/system/flagsGen.service && \
    systemctl enable flagsGen.service

RUN systemctl enable apache2

EXPOSE 80

CMD ["/lib/systemd/systemd"]
