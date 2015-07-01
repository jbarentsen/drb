# DWS BASE APPLICATION


## Vagrant

1. Install [vagrant](https://www.vagrantup.com/downloads.html),
[ansible](http://docs.ansible.com/intro_installation.html#latest-releases-via-homebrew-mac-osx) and
[VirtualBox](https://www.virtualbox.org/wiki/Downloads).
2. Follow instructions on [this page](https://docs.vagrantup.com/v2/synced-folders/nfs.html) to enable NFS mount (vagrant will ignore NFS option for windows).
3. Turn off your firewall or adjust it to accept NFS connection.
4. Open a terminal in the project's folder and run ```vagrant up```. It may
take some time to do finish ( get some coffee )
5. If you get an error ( in red ) from ```composer install```. Please ignore it and make sure to run it again manually after vagrant is up.

Once it's finished you can ```vagrant ssh``` into your virtual machine.
The document root is set to ```/var/www/leagues.datawiresport.com```, you

can find error logs in ```/var/log/nginx/error.log``` and  ```/var/log/php5/error.log```.


- Access the application at [http://192.168.33.31](http://192.168.33.31).
- Access phpMyAdmin at [http://192.168.33.31:8282](http://192.168.33.31:8282).

## Hosts file

- Add ```manager.leagues.datawiresport.dev``` ,```api.leagues.datawiresport.dev```, ```portal.leagues.datawiresport.dev``` to your local hosts file pointing to ```192.168.33.31```.

## Mounting NFS without password

- To mount NFS without OS X asking for a password add these lines to ```/etc/sudoers```
```
Cmnd_Alias VAGRANT_EXPORTS_ADD = /usr/bin/tee -a /etc/exports
Cmnd_Alias VAGRANT_NFSD = /sbin/nfsd restart
Cmnd_Alias VAGRANT_EXPORTS_REMOVE = /usr/bin/sed -E -e /*/ d -ibak /etc/exports
%admin ALL=(root) NOPASSWD: VAGRANT_EXPORTS_ADD, VAGRANT_NFSD, VAGRANT_EXPORTS_REMOVE
```

## Endpoint permissions

By default access to all endpoints is denied. You either whitelist an endpoint in configuration or add it to a role. Endpoints can be inherited from parent roles.
To update the endpoints from config to the database run ```php public/index.php endpoints update```. This will remove oldpoints and add new ones.


## Use Xdebug

- To enable Xdebug add these lines to ```server/config/development/php/xdebug.ini```
```
xdebug.remote_enable = on
xdebug.remote_connect_back = on
xdebug.idekey = "PHPSTORM"
```
- Reload PHP-FPM
```
sudo service php5-fpm reload
```
- Configure your IDE [example](http://confluence.jetbrains.com/display/PhpStorm/Zero-configuration+Web+Application+Debugging+with+Xdebug+and+PhpStorm)

## Update dependencies

- If you switch branch or change composer.json please remember to
 ```vagrant ssh``` and run ```cd /var/www/leagues.datawiresport.com && composer update  --prefer-dist```

## [MailCatcher](http://mailcatcher.me/)

- MailCatcher will catch all emails sent through vagrant via Postfix and will display the mail on [http://192.168.33.31:1080/](http://192.168.33.31:1080/)

## [FishShell](http://fishshell.com/)

- vagrant and root users are using fish shell by default. If you like to switch to bash please use ```sudo chsh -s /bin/bash vagrant```

## Server config

- Most config files are located in ```server``` dir on root. Please make changes and reload the service to apply.

## [Apigility](https://apigility.org/)

- To use Apigility make sure to enable development mode ```php public/index.php development enable ```
- To use the admin UI run ``` php -S 0.0.0.0:8888 -t public public/index.php ``` then visit [http://api.leagues.datawiresport.dev:8888/apigility/ui](http://api.leagues.datawiresport.dev:8888/apigility/ui)

## Frontend

- To init frontend files ssh to Vagrant then run:
```
cd /var/www/leagues.datawiresport.com/frontend
gulp --production
```
then point your browser to ```manager.leagues.datawiresport.dev```

## CodeSniffer

- Run CodeSniffer with the following command to check the syntax. It uses the PSR2 syntax, with line length extended to 150.
```
vendor/bin/phpcs --standard=config/ruleset.xml  module
vendor/bin/phpcbf --standard=config/ruleset.xml  module
```

##  [Postman](https://www.getpostman.com/)

- Download the Packaged app [here](https://chrome.google.com/webstore/detail/postman-rest-client-packa/fhbjgbiflinjbdggehcddcbncdddomop).
- Postman collection and evironment files are located in ```data/postman```
- Import these files to your postman and you will be able to use the API and run Postman/newman collection tests

##  Configuring instances

- Staging:
   - Install ```ansible-playbook -i deploy/ansible/inventory/staging deploy/ansible/provision.yml  -u root```
   - Deploy  ```ansible-playbook -i deploy/ansible/inventory/staging deploy/ansible/deploy.yml  -u root```

##  [Beanstalkd](http://kr.github.io/beanstalkd/)

- Copy ```config/autoload/slm_queue_beanstalkd.local.php.dist``` into ```config/autoload/slm_queue_beanstalkd.local.php```
- make sure beanstalkd ```sudo service beanstalkd start  ```
- Run ```php index.php queue beanstalkd NcpCommunicationQueue ```  to start processing the Queues

## TODO

- Translations
- Queue interface + factory. => Publisher als consumer
- Queue for processing and flagging entities
https://github.com/davidpersson/beanstalk
- Unit testing
- Full text search with Sphinx of elasticsearch(?)
- Integrate default Collection responses with Paginated containers (where to put this)
- Working with sub-forms
- Working with Redis
- Email/SMS Carrier structure, including queue/retry/validation
- Working with JOINS and relationships in Eloquent model
- Structure for report data and generation
- Report output types: CSV, Excel, PDF?
https://packagist.org/packages/psliwa/php-pdf ?
https://packagist.org/packages/phpoffice/phpexcel
- add docs for HHVM, Redis and Beanstalkd



