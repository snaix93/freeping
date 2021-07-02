#!/bin/bash
set -e

#
# This script is executed on the destination host after the build is finished
# The Bitbucket Pipeline executes the script over SSH using the default www-data user
#
test -e /tmp/$BUILD
test -e /var/www/.freeping.io && rm -rf /var/www/.freeping.io
test -e /var/www/freeping.io || mkdir /var/www/freeping.io
mkdir /var/www/.freeping.io
tar xzf /tmp/$BUILD -C /var/www/.freeping.io/

cd /var/www/.freeping.io

# Activate the new build
mv /var/www/freeping.io /var/www/_freeping.io
mv /var/www/.freeping.io /var/www/freeping.io

# Clean up
rm -rf /var/www/_freeping.io
rm -f /tmp/$BUILD

# Clear Complied/Routes/Cache/Config/Event/View
php artisan cache:clear --no-interaction
php artisan config:clear --no-interaction
php artisan clear-compiled --no-interaction
php artisan optimize:clear --no-interaction

# Migrate DB
php artisan migrate --no-interaction --force

# Cache Routes/Events/Config
php artisan route:cache --no-interaction
php artisan event:cache --no-interaction
php artisan config:cache --no-interaction
php artisan livewire:discover --no-interaction

# Will reload via the systemd config.
sudo -n cp freeping-queue-worker.service /etc/systemd/system/
sudo -n cp freeping-short-schedule-worker.service /etc/systemd/system/
sudo -n systemctl daemon-reload

# Start service if not running
sudo -n systemctl status freeping-queue-worker.service||sudo -n systemctl start freeping-queue-worker.service
sudo -n systemctl status freeping-short-schedule-worker.service||sudo -n systemctl start freeping-short-schedule-worker.service
# Enable the autostart of services on boot
sudo -n systemctl enable freeping-queue-worker.service
sudo -n systemctl enable freeping-short-schedule-worker.service

sudo -n systemctl restart freeping-short-schedule-worker.service

php artisan horizon:terminate
php artisan storage:link
php artisan clear-in-progress

# Create an empty log file.
# The monitoring throws errors if the file doesn't exist
source .env
test -e storage/logs/${LOG_FILE}||touch storage/logs/${LOG_FILE}
