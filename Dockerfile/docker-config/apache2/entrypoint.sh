#!/usr/bin/env sh

echo "Changing owner/group of /var/www/html/** from root to www-data, this might take a while..."
chown -R www-data:www-data /var/www/html > /dev/null 2>&1
echo "Done :)"
echo "Switching to apache!"
echo ""

exec docker-php-entrypoint "$@"
