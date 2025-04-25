@echo off
echo %date% %time% - Running Nextcloud cron >> "D:\nextcloud_data\data\cron.log"
docker exec -u 33 nextcloud php -f /var/www/html/cron.php >> "D:\nextcloud_data\data\cron.log" 2>&1