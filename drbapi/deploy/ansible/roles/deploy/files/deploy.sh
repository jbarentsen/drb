#!/bin/bash

set -e
TEXTSTART="\n\e[0;33m####"
TEXTEND="\e[0m"
WEBSERVER_CONFIG_PATH=/var/www/leagues.datawiresport.com/deploy/ansible/roles/webserver/files/staging/config


echo -e "$TEXTSTART Starting Deploy on Staging.. $TEXTEND"

echo -e "$TEXTSTART Extracting deploy package $TEXTEND"
if [ -f /tmp/ncp.tar.bz2 ]
then
    cd /var/www/
    rm -rf leagues.datawiresport.com.deploy
    mkdir leagues.datawiresport.com.deploy
    tar jxf /tmp/ncp.tar.bz2 --directory leagues.datawiresport.com.deploy

    #mv leagues.datawiresport.com leagues.datawiresport.com.$(date '+%Y_%m_%d__%H_%M_%S')
    rm -rf leagues.datawiresport.com

    mv leagues.datawiresport.com.deploy leagues.datawiresport.com
else
    echo -e "\n\e[0;31m########### /tmp/ncp.tar.bz2 not found $TEXTEND"
fi

echo -e "$TEXTSTART Coping config files $TEXTEND"
/bin/cp "$WEBSERVER_CONFIG_PATH"/hhvm/hhvm /etc/init.d/hhvm
/bin/cp "$WEBSERVER_CONFIG_PATH"/hhvm/server.ini /etc/hhvm/server.ini
/bin/cp "$WEBSERVER_CONFIG_PATH"/hhvm/server.ini /etc/hhvm/server.ini
/bin/cp "$WEBSERVER_CONFIG_PATH"/hhvm/php.ini /etc/hhvm/php.ini
/bin/cp "$WEBSERVER_CONFIG_PATH"/nginx/nginx.conf /etc/nginx/nginx.conf
/bin/cp "$WEBSERVER_CONFIG_PATH"/nginx/fastcgi_params /etc/nginx/fastcgi_params
/bin/cp "$WEBSERVER_CONFIG_PATH"/php5/cli/php.ini /etc/php5/cli/php.ini
/bin/cp "$WEBSERVER_CONFIG_PATH"/php5/fpm/php.ini /etc/php5/fpm/php.ini
/bin/cp "$WEBSERVER_CONFIG_PATH"/php5/fpm/php-fpm.conf /etc/php5/fpm/php-fpm.conf


echo -e "$TEXTSTART Configuring Permissions $TEXTEND"
mkdir -p /var/run/hhvm || true
chmod -R 777 /var/run/hhvm
mkdir -p /var/run/user/hhvm || true
chmod -R 777 /var/run/user/hhvm
chmod -R 777 /var/www/leagues.datawiresport.com/data/DoctrineORMModule/Proxy

cd /var/www/leagues.datawiresport.com/
#./vendor/bin/classmap_generator.php

echo -e "$TEXTSTART Updating Database schema $TEXTEND"
# php /var/www/leagues.datawiresport.com/public/index.php dbal:run-sql "DROP DATABASE ta_ncp; CREATE DATABASE ta_ncp;"
# Drop and create database
mysqladmin -u root drop ta_ncp -f
mysqladmin -u root create ta_ncp -f
#php /var/www/leagues.datawiresport.com/public/index.php orm:schema-tool:drop --force
php /var/www/leagues.datawiresport.com/public/index.php orm:schema-tool:update --force
php /var/www/leagues.datawiresport.com/public/index.php migration apply

echo -e "$TEXTSTART Restarting web services $TEXTEND"
service hhvm restart
service php5-fpm reload
service nginx reload


echo -e "\n\n\n\n\e[0;32m#######################\n#### Deploy Is Successful\n####################### $TEXTEND"