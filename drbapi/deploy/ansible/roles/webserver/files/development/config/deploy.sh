#!/bin/bash

set -e

sudo mkdir /var/run/hhvm || true
sudo chmod -R 777 /var/run/hhvm
sudo mkdir /var/run/user/hhvm || true
sudo chmod -R 777 /var/run/user/hhvm


sudo service hhvm restart
sudo service php5-fpm restart
sudo service nginx restart
