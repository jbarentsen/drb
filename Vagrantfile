# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'

@script = <<SCRIPT
apt-get update
apt-get install -y apache2 git curl php5-cli php5 php5-intl libapache2-mod-php5

a2enmod rewrite
a2dissite 000-default
a2ensite drbadmin
service apache2 restart
cd /var/www/dev.drbadmin.de
curl -Ss https://getcomposer.org/installer | php
php composer.phar install --no-progress
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = 'chef/ubuntu-14.04'
  config.ssh.forward_agent = true
  config.vm.network "private_network", ip: "192.168.33.30", auto_correct: true
  config.vm.hostname = "dev.drbadmin.de"
  config.vm.synced_folder ".", "/vagrant", disabled: true
  config.vm.synced_folder ".", "/var/www/dev.drbadmin.de", :nfs => { group: "www-data", owner: "www-data" }, :mount_options => ['nolock,vers=3,udp,noatime']


#  config.vm.synced_folder '.', '/var/www/zf'
  config.vm.provision 'shell', inline: @script

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--memory", "1024"]
  end

end
