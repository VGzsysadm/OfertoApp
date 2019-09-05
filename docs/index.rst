OfertoApp
=========
Maneja tus canales de referidos, publica y controla los chollos de tus tiendas online preferidas. Distribuye tus referidos a tus afiliados. Totalmente gratis y opensource.

.. image:: https://img.shields.io/badge/PHP-7.3-green
.. image:: https://img.shields.io/badge/Symfony-4.0-green
.. image:: https://img.shields.io/badge/license-MIT-green

.. image:: https://raw.githubusercontent.com/VGzsysadm/OfertoApp/master/public/logo_transparent.png

Requeriments
------------
.. code:: bash

  PHP 7.3.0 or higher ( php-xml, php-zip & php-mysql extensions are required)
  MySQL or PostgreSQL
  Web server
  Composer
  Google IAM Service Account Credentials API

Prerequisites
-------------
* Ensure that you created a user for mysql before.
.. code:: mysql

  create database ofertoapp;
  create user user_ofertoapp@localhost;
  SET PASSWORD FOR 'user_ofertoapp'@'localhost' = PASSWORD('secure_password_here');
  GRANT ALL PRIVILEGES ON ofertoapp.* to 'user_ofertoapp'@'localhost' IDENTIFIED BY 'secure_password_here';
  flush privileges;
  exit

Installation
------------
* Download the project from `Source Forge <https://sourceforge.net/projects/ofertoapp/files/>`_. or clone the project from github.

* Modify the line DATABASE_URL & APP_ENV and Google information with your data at the .env file.
.. code:: bash

  APP_ENV=prod
  GOOGLE_CLIENT_ID=
  GOOGLE_CLIENT_SECRET=
  DATABASE_URL=mysql://user_ofertoapp:secure_password_here@127.0.0.1:3306/ofertoapp

* Inside the project folder execute composer install.

.. code:: bash

  composer install --no-dev --optimize-autoloader

* Go to the file /config/packages/doctrine.yaml and add the following parameters in the beginning
.. code:: bash

  parameters:
      database_driver: pdo_mysql
      database_host: 127.0.0.1
      database_port: 3306
      database_name: ofertoapp
      database_user: user_ofertoapp
      database_password: secure_password_here

* Update the schema with doctrine
.. code:: bash

  php bin/console doctrine:schema:update --force

* Migrate some required data
.. code:: bash

  php bin/console doctrine:migrations:execute --up 01

* Configure permissions, virtualhost and logs
.. code:: bash

  chown -R www-data /var/www/OfertoApp
  a2enmod rewrite

* Enable default vhost for apache2 example:
.. code:: bash

  <VirtualHost *:80>
        ServerName your_domain_here.com
        ServerAlias your_domain_here.com www.your_domain_here.com
        DocumentRoot /var/www/OfertoApp/public
        <Directory /var/www/OfertoApp/public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
                <IfModule mod_rewrite.c>
                Options -MultiViews
                RewriteEngine On
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteRule ^(.*)$ index.php [QSA,L]
                </IfModule>
        </Directory>
        <Directory /var/www/OfertoApp>
        Options FollowSymlinks
        </Directory>
        ErrorLog /var/log/apache2/OfertoApp/project_error.log
        CustomLog /var/log/apache2/OfertoApp/project_access.log combined
  </VirtualHost>

* Clear the cache in the project directory for prod env
.. code:: bash

  APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear