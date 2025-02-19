#!/bin/bash
LOGFILE="./frankenphp.log" ERRORLOG="./frankenphp-error.log"
# Menjalankan FrankenPHP dengan logging
frankenphp php-server -r . -l 127.0.0.1:81 >> "$LOGFILE" 2>> "$ERRORLOG" & echo "FrankenPHP server started on 127.0.0.1:81"

#stop
#pkill -f "frankenphp php-server"