#!/bin/bash
#
# Project Manager — workspace uploads backup
# Snapshots the shared uploads directory into /var/backups.
# Intended to be run as root (via sudo) by the on-call admin.
#
BACKUP_DIR="/var/backups"
SRC="/var/www/uploads"

mkdir -p "$BACKUP_DIR"

cd "$SRC" || { echo "[-] uploads directory not found"; exit 1; }

echo "[*] Backing up $SRC ..."
/usr/bin/tar czf "$BACKUP_DIR/uploads-$(date +%F).tgz" *
echo "[+] Backup written to $BACKUP_DIR/uploads-$(date +%F).tgz"
