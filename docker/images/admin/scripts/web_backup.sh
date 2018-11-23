#!/bin/sh

echo "[ $(date +"%Y.%m.%d %H:%M:%S") ] Backup script started."

zip -r --symlinks /backup/web/$(date +"%Y%m%d_%H%M%S").zip /public \
    -x public/build/**\* \
    -x public/bundles/**\* \
    -x public/index.php

echo "[ $(date +"%Y.%m.%d %H:%M:%S") ] Backup script finished."