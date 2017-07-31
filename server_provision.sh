#!/usr/bin/env bash

PROJECT_NAME="pagarme"
APACHE_LOG_DIR="/var/log/apache2/"

DOCUMENT_ROOTS[0]='/var/www/pagarme/web/';

VIRTUALHOST_FILE_NAME[0]="pagarme.conf";
IP_HOST="172.28.128.1"

URI[0]="pagarme.test";

export LC_ALL=C;
echo export LC_ALL=C; >> ~/.bashrc;
sudo usermod -a -G www-data vagrant;

cd $DOCUMENT_ROOTS[0];
sudo chmod 775 ./ -R;

sudo apt update;
echo "############ DEPENDENCIAS BACKEND ############"
echo "############ Instalando curl ############";
sudo apt-get install -y curl;

echo "############ Instalando apache ############";
sudo apt install -y apache2 libapache2-mod-php7.0;

echo "############ Instalando php 7.0 ############";
sudo apt install -y php7.0 php7.0-cli php7.0-common php7.0-curl php7.0-gd php7.0-dev  php7.0-zip php7.0-xml php7.0-soap php7.0-opcache php7.0-mcrypt php7.0-mysql php-xdebug php7.0-mbstring php-bcmath composer -y;


sudo echo "
xdebug.remote_enable=1
xdebug.remote_host=${IP_HOST}
xdebug.remote_port=9000
xdebug.remote_autostart=1
xdebug.remote_handler = dbgp
xdebug.remote_mode = req
" >> /etc/php/7.0/apache2/conf.d/20-xdebug.ini;

sudo a2dissite *;
sudo a2enmod rewrite;

for index in 0
do

echo "############ Criando ${VIRTUALHOST_FILE_NAME[index]} VirtualHost Apache ############"
echo "
<VirtualHost *:80>
    ServerName ${URI[index]}
    DocumentRoot ${DOCUMENT_ROOTS[index]}
    <Directory ${DOCUMENT_ROOTS[index]}>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            #RewriteBase /path/to/app
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^ index.php [QSA,L]
        </IfModule>
    </Directory>
    ErrorLog ${APACHE_LOG_DIR}${URI[index]}error.log
</VirtualHost>" > /etc/apache2/sites-available/${VIRTUALHOST_FILE_NAME[index]};


sudo a2ensite ${VIRTUALHOST_FILE_NAME[index]};

done

echo "############ Reinicia servidor apache ############"
sudo service apache2 restart

echo "############ DEPENDENCIAS FRONT END ############"
echo "############ Instalando npm e bower ############";
sudo apt install npm nodejs -y;
sudo ln -s /usr/bin/nodejs  /usr/bin/node
sudo npm install -g bower;
sudo npm install -g gulp;

cd ${DOCUMENT_ROOTS[0]};
bower install install --allow-root;


echo "############ Instalando dependencias do projeto ############"
cd ../;
composer install;


cd ${DOCUMENT_ROOTS[0]};
sudo chmod 775 ./ -R;