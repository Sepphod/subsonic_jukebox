#!/bin/sh

# Enable commonly used apache modules
sed -i 's/#LoadModule\ rewrite_module/LoadModule\ rewrite_module/' /etc/apache2/httpd.conf
sed -i 's/#LoadModule\ deflate_module/LoadModule\ deflate_module/' /etc/apache2/httpd.conf
sed -i 's/#LoadModule\ expires_module/LoadModule\ expires_module/' /etc/apache2/httpd.conf

sed -i "s#^DocumentRoot \".*#DocumentRoot \"/jukebox/public\"#g" /etc/apache2/httpd.conf
sed -i "s#/var/www/localhost/htdocs#/jukebox/public#" /etc/apache2/httpd.conf
printf "\n<Directory \"/jukebox/public\">\n\tAllowOverride All\n</Directory>\n" >> /etc/apache2/httpd.conf

# Logs redirection configuration via LOG_CONF environment variable
ln -sf /dev/stdout /var/log/apache2/access.log
ln -sf /dev/stderr /var/log/apache2/error.log

chown -R apache:apache /jukebox

httpd -D FOREGROUND
