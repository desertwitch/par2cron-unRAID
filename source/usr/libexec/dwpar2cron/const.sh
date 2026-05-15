#!/bin/bash
P2C_PID_FILE="/var/run/dwpar2cron.pid"
P2C_SVLOGD="/usr/libexec/dwpar2cron/svlogd"
P2C_LOG_DIR="/var/log/dwpar2cron/log"
P2C_LOG_FILE="$P2C_LOG_DIR/current"
P2C_JSON_DIR="/var/log/dwpar2cron/json"
P2C_JSON_FILE="$P2C_JSON_DIR/current"

if [ -d /mnt/user ]; then
    if [ -d /mnt/user/system ]; then
        P2C_CACHE_DIR="/mnt/user/system/par2cron/cache"
    elif mountpoint -q /dev/shm; then
        P2C_CACHE_DIR="/dev/shm/par2cron/cache"
    else
        P2C_CACHE_DIR="/tmp/par2cron/cache"
    fi
    mkdir -p "$P2C_CACHE_DIR"
fi

true
