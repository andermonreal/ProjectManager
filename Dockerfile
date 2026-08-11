FROM ubuntu:latest

RUN apt update && apt install -y \
    apache2 \
    php \
    build-essential \
    systemd \
    openssl \
    sudo \
    && apt clean


# --- Intermediate accounts (lateral movement) ---
# melendez: reachable from www-data by reusing the OS password that is also
#           the web credential cracked during enumeration (melendez123).
# monre:    has no usable password, so the only way in is exploiting the
#           SUID buffer-overflow tool below.
RUN useradd -m -s /bin/bash melendez && \
    echo 'melendez:melendez123' | chpasswd && \
    useradd -m -s /bin/bash monre && \
    passwd -l monre

# monre -> root: passwordless sudo on a root backup script that is vulnerable
# to GNU tar wildcard injection. The script runs `tar ... *` inside a directory
# that monre can write to, so dropping crafted --checkpoint files executes code
# as root.
COPY backup.sh /opt/pm/backup.sh
RUN chown root:root /opt/pm/backup.sh && chmod 0755 /opt/pm/backup.sh && \
    mkdir -p /var/www/uploads && chown monre:monre /var/www/uploads && chmod 0755 /var/www/uploads && \
    echo 'monre ALL=(root) NOPASSWD: /opt/pm/backup.sh' > /etc/sudoers.d/monre && \
    chmod 0440 /etc/sudoers.d/monre


# --- Flags ---
# user flag belongs to melendez (first lateral-movement hop), root flag to root.
RUN echo "ssi{$(openssl rand -hex 8)}" > /home/melendez/user.txt && \
    chown melendez:melendez /home/melendez/user.txt && \
    chmod 600 /home/melendez/user.txt && \
    echo "ssi{$(openssl rand -hex 8)}" > /root/root.txt && \
    chmod 600 /root/root.txt && \
    rm -rf /home/ubuntu


# --- melendez -> monre: SUID (monre) buffer-overflow tool ---
COPY adminAuth.c /home/melendez/adminAuth.c
RUN gcc -fno-stack-protector -z execstack -std=gnu99 \
        -o /home/melendez/adminAuth /home/melendez/adminAuth.c && \
    rm -f /home/melendez/adminAuth.c && \
    chown monre:monre /home/melendez/adminAuth && \
    chmod 4755 /home/melendez/adminAuth

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
