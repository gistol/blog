#!/bin/sh

echo "[ $(date +"%Y.%m.%d %H:%M:%S") ] Backup script started."

docker exec app_mysql \
    sh -c 'exec mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"' \
    > /backup/db/$(date +"%Y%m%d_%H%M%S")_"$MYSQL_DATABASE".sql

echo "[ $(date +"%Y.%m.%d %H:%M:%S") ] Backup script finished."