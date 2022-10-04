# TuChance

TuChance es una aplicación diseñada como Cliente - API.

Esto quiere decir que tanto el componente Front-End y el Back-End de la aplicación se encuentran hasta cierta medida separados el uno del otro.

### Infraestructura

La infraestructura del servidor de TuChance es la siguiente

- **Linux Debian 9:** Sistema Operativo.
- **nginx:** Servidor web una huella en memoria liviana.
- **MySQL 5.6:** Gestor de base de datos Open Source
- **PHP 7.1:** Lenguaje de programación del lado del servidor, orientado al desarrollo web.

##Acceso al servidor

### ¿SSH?

SSH o Secure Shell, es un protocolo de administración remota que permite a los usuarios controlar y modificar sus servidores remotos a través de Internet. El servicio se creó como un reemplazo seguro para el Telnet, el cual no transmite los datos de forma encriptada. SSH utiliza técnicas criptográficas para garantizar que todas las comunicaciones hacia y desde el servidor remoto sucedan de manera encriptada. Además, proporciona un mecanismo para autenticar un usuario remoto, transferir entradas desde el cliente al host y retransmitir la salida de vuelta al cliente.

### ¿Qué son las llaves SSH?

Sin duda, el método más seguro de autenticación para el acceso remoto por medio de SSH, son las llaves públicas y privadas.

Este es un mecanismo que permite al protocolo identificar a un cliente por medio de un certificado público instalado en el mismo, y comparándolo con uno privado en el cliente.

Podemos imaginar que la llave pública es un cerrojo, y la llave privada es, valga la redundancia, la llave que abre dicho cerrojo.

### ¿Por qué es más seguro?

La autenticación por llave SSH permite proveer acceso únicamente a clientes autorizados, y revocar el acceso a los mismos a discreción, sin necesidad de redistribuir credenciales.

Además, es posible asignar una contraseña a la llave privada, de forma que cada vez que sea utilizada para autenticarse en un servidor, la contraseña deberá ser provista.

Para generar una llave SSH en un sistema basado en UNIX, se debe ejecutar el siguiente comando:

	ssh-keygen -t dsa -b 1024

Esto nos brindará la opción de colocar una contraseña.

### ¿Cómo autorizo una llave en un servidor?

Para generar una llave SSH en un sistema basado en UNIX, se debe ejecutar el siguiente comando:

	# en el equipo 'servidor'
	user@server:~$ mkdir .ssh; chmod 700 .ssh
	user@server:~$ cd .ssh
	user@server:~$ touch authorized_keys; chmod 600 authorized_keys

## Instalación del entorno

Para este ambiente será necesario contar con las siguientes dependencias instaladas en el sistema:

- PHP >= 7.1.3
- Extensión BCMath para PHP
- Extensión Ctype para PHP
- Extensión JSON para PHP
- Extensión Mbstring para PHP
- Extensión OpenSSL para PHP
- Extensión PDO para PHP
- Extensión Tokenizer para PHP
- Extensión XML para PHP
- MySQL
- Git
- Deployer
- NodeJS
- Yarn

Los pasos para instalar varían de sistema operativo en sistema operativo, pero se describirán los pasos para instalarlos en un sistema Linux con distribución Debian.

###Instalando nginx

Será necesario actualizar los repositorios del sistema operativo y luego procedemos con la instalación más simple de este entorno, nginx:

	$ sudo apt-get update
	$ sudo apt-get install nginx

###Instalando PHP

Para instalar PHP y las extensiones necesarias:

	$ sudo apt-get install php7.1 \
	    php7.1-json \
	    php7.1-mysql \
	    php7.1-zip \
	    php7.1-bcmath \
	    php7.1-xml \
	    php7.1-curl \
	    php7.1-fpm \
	    php7.1-mbstring \
	    php7.1-opcache \
	    php7.1-sqlite3 \
	    php7.1-xmlrpc \
	    php7.1-gd \
	    php7.1-mcrypt \
	    php7.1-xsl

###Instalando MySQL

Para instalar el servidor de MySQL:

	$ sudo apt-get install mysql-server

***IMPORTANTE***

En algunos sistemas, el password del usuario root de la base de datos no es solicitado durante la instalación de MySQL, en este caso es necesario seguir el siguiente procedimiento:

	#detener el proceso
	$ sudo service mysql stop
	#crear el directorio donde reside el socket de conexión y asignar permisos
	$ sudo mkdir -p /var/run/mysqld
	$ sudo chown mysql:mysql /var/run/mysqld
	#iniciar el proceso nuevamente sin autenticación
	$ sudo /usr/sbin/mysqld --skip-grant-tables --skip-networking &

Tras esto será posible ingresar al cliente de MySQL y cambiar el password

	$ mysql -u root
	Welcome to the MySQL monitor.  Commands end with ; or \g.
	Your MySQL connection id is 3
	Server version: 5.7.20-1ubuntu1 (Ubuntu)

	Copyright (c) 2000, 2017, Oracle and/or its affiliates. All rights reserved.

	Oracle is a registered trademark of Oracle Corporation and/or its
	affiliates. Other names may be trademarks of their respective
	owners.

	Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

	mysql> USE mysql;
	Database changed
	mysql> UPDATE user SET authentication_string=PASSWORD("NEWPASSWORD") WHERE User='root';
	Query OK, 0 rows affected, 1 warning (0.00 sec)
	Rows matched: 1  Changed: 0  Warnings: 1

	mysql> UPDATE user SET plugin="mysql_native_password" WHERE User='root';
	Query OK, 0 rows affected (0.00 sec)
	Rows matched: 1  Changed: 0  Warnings: 0

	mysql> FLUSH PRIVILEGES;
	Query OK, 0 rows affected (0.00 sec)

	mysql> quit

Con esto hecho, se termina el proceso de mysql y se procede a reiniciar el servicio

    $ sudo pkill mysqld
    $ sudo service mysql start

### Instalar composer

Composer es un gestor de dependencias de PHP. Para instalarlo de forma global en el sistema, se ejecutan los siguientes comandos

	$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	$ php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	$ php composer-setup.php
	$ php -r "unlink('composer-setup.php');"
	$ sudo mv ./composer.phar /usr/bin/composer

### Instalar git

Git es es un software de control de versiones, para instalarlo es necesario:

	$ sudo apt-get install git

### Instalar NodeJS y Yarn

NVM es un manager de versiones para NodeJS y es la forma más transparente de instalar dicho software. Para ello se ejecutan los siguientes comandos.

	$ curl -sL https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh -o install_nvm.sh
	$ bash install_nvm.sh
	$ source ~/.profile

Ahora ya podremos utilizar NVM:

	$ nvm install node
	$ nvm use node

Con esto ya contamos con node, y será posible instalar `yarn`:

	$ npm install -g yarn


## Levantar el proyecto

En primer lugar se debe clonar el repositorio

	$ git clone git@git.iw.sv:giz/tuchance/website.git
	# Cambiar a la branch correspondiente al país
	$ git checkout (elsalvador|honduras|guatemala)

Primero es necesario contar con una base de datos para el proyecto:

    $ mysqladmin create -u root -p tuchance

***Recomendado:***

Crear una base de datos y un usuario con los privilegios necesario únicamente para la base de datos del proyecto:

	mysql> CREATE USER 'tuchance'@'localhost' IDENTIFIED BY 'password';
	mysql> GRANT ALL PRIVILEGES ON tuchance.* TO 'tuchance'@'localhost';
	mysql> FLUSH PRIVILEGES;
	mysql> CREATE USER 'tuchance'@'127.0.0.1' IDENTIFIED BY 'password';
	mysql> GRANT ALL PRIVILEGES ON tuchance.* TO 'tuchance'@'127.0.0.1';
	mysql> FLUSH PRIVILEGES;

***Sustituir password por un password seguro***

Posterior `.env.example` file:

	$ cp .env.example .env

Nos aseguramos de configurar las credenciales para la conexión:

	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=tuchance
	DB_USERNAME=tuchance
	DB_PASSWORD=password

Procedemos con la instalación de las liberías de terceros a través de composer:

	$ composer install

Procedemos con la instalación de las librerías de terceros a través de yarn:

	$ yarn install

Luego de esto, es necesario configurar dos llaves, una de la aplicación y la otra como parte del algoritmo de encriptación de los tokens generados para autenticar usuarios:

	$ php artisan key:generate
	$ php artisan jwt:secret

Luego se debe migrar la base de datos:

	$ php artisan migrate --seed

Por último será necesario importar el catálogo de todos los países:

	$ mysql -u root -p < tuchance_gt_6-19-19_9-07 AM.sql

Si se desea contar con algunas oportunidades de prueba es posible:

	$ php artisan db:seed --class=OpportunitiesTableSeeder

## Ambiente de desarrollo:

Si no se cuenta con un entorno en el que existe [Valet](https://laravel.com/docs/5.4/valet) se debe correr el proyecto con:

	$ php artisan serve

Es posible accederlo a través de `http://localhost:8080`

## Ambiente de producción

En un ambiente de producción todos los pasos anteriores aplican. Excepto que será necesario configurar el servidor para recibir las peticiones del dominio designado:

***Recomendado***

Como primer paso, deberemos crear un usuario con privilegios únicamente para los archivos correspondientes a su instancia de TuChance.

	$ sudo adduser tuchance

Se nos solicitará el password a asignar. De esta manera podremos ejecutar PHP bajo este usuario en lugar del usuario de nginx, asegurando los permisos necesarios para la plataforma únicamente en los archivos que le corresponden.

Para ejecutar php con el nuevo usuario creado, debemos ejecutar un nuevo pool del Fast Process Manager de PHP. Hacemos esto creando un nuevo archivo:

	$ sudo nano /etc/php/7.1/fpm/pool.d/tuchance.conf

El contenido de este archivo debe verse de la siguiente manera

	[tuchance]
	user = tuchance
	group = tuchance
	listen = /var/run/php71-fpm-tuchance.sock
	listen.owner = www-data
	listen.group = www-data
	php_admin_value[disable_functions] = exec,passthru,shell_exec,system
	php_admin_flag[allow_url_fopen] = off
	pm = dynamic
	pm.max_children = 50
	pm.start_servers = 20
	pm.min_spare_servers = 5
	pm.max_spare_servers = 35
	chdir = /

Ahora procedemos a reiniciar el proceso de PHP

	$ sudo service php7.1-fpm restart

Ahora podemos iniciar sesión como el nuevo usuario creado

	$ su tuchance

Una vez en la home del nuevo usuario, creamos un directorio `logs` y un directorio `www`.

	$ mkdir logs www

Será necesario clonar el repositorio del proyecto en la carpeta `www` y ejecutar los pasos descritos en el ambiente de desarrollo en la cuenta del nuevo usuario.

Una vez esto ha sido completado, cerramos la sesión y de nuevo como `root` creamos el server block. Editando el archivo

	$ sudo nano /etc/nginx/sites-available/tuchance

El archivo se verá algo como esto:

	server {
		listen 80;
		server_name tuchange.org;
		rewrite ^/(.*)$ http://tuchance.org/$1 permanent;
	}

	server {
		listen 80;

		server_name tuchance.org;

		proxy_set_header X-Forwarded-For $remote_addr;

		add_header Strict-Transport-Security "max-age=31536000; includeSubDomains";
		server_tokens off;

		access_log /home/tuchance/logs/nginx.access;
		error_log /home/tuchance/logs/nginx.error;

		index index.php index.html index.htm;

		root /home/tuchance/www/public;

		location / {
			try_files $uri $uri/ /index.php?$query_string;
		}

		location ~ \.php$ {
			try_files $uri /index.php =404;
			fastcgi_split_path_info ^(.+\.php)(/.+)$;
			fastcgi_read_timeout 150;
			fastcgi_pass unix:/var/run/php71-fpm-tuchance.sock;
			fastcgi_index index.php;
			fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
			include fastcgi_params;
		}
	}

### Instalado un certificado SSL

Un certificado SSL solo puede ser emitido tras una verificación de identidad de un dominio.
Además, cualquier información intercambiada entre un cliente y un servidor, se encuentra encriptada, de forma tal que un atacante no puede interceptarla.

Por último, el explorador Google Chrome, desde el cual se genera más del 64%  del tráfico en línea, marca cualquier sitio accedido por el protocolo http (sin ssl) como no seguro dede su versión 68, actualmente la más reciente es la 71 (Enero 2019).

###Adquirir Certificado

La adquisición de un certificado, no representa más que cancelar a una entidad emisora, por realizar un proceso de validación sobre un dominio, y

###Generar CSR y llave privada

Una vez adquirido el certificado, la entidad emisora nos solicitará la generación de un Certificate Signing Request. Este es un certificado que contiene información sobre la identidad del dominio.

Al mismo tiempo genera una llave privada, que servirá para valida que el certificado emitido e instalado en el servidor, fue emitido para la entidad que fue validada. Por tanto esta llave privada no se debe compartir en ningún momento.

Existen insumos en línea para facilitar la generación de estos archivos

- [CSR Generator](https://csrgenerator.com/)
- [Digicert - Crear CSR](https://www.digicert.com/es/crear-csr.htm)


###Proceso de validación

La validación del dominio puede efectuarse típicamente por uno de tres métodos para los certificados más simples.

Uno es colocando un archivo provisto por la entidad emisora, típicamente dentro del directorio .well-known/pki-validation/ que a su vez está ubicado en raíz del dominio.

El segundo implica agregar una entrada de tipo TXT con el valor especificado por la entidad emisora a la zona DNS del dominio.

El último implica recibir un correo en una de las direcciones típicamente asociadas a los administradores de un dominio, tales como admin, webmaster, hostmaster, etc.

###Preparar certificados intermedios

Las directivas de nginx permiten únicamente configurar un certificado, y no es posible apuntar a un certificado raíz o intermedio por medio de una directiva dentro de nuestro bloque de servidor. Por tanto es necesario generar concatenar nuestros archivos raiz e intermedio en el orden correcto.

- Certificado Raíz. Ejemplo nombre: AddTrustExternalCARoot.crt
- Certificado Intermedio 1. Ejemplo nombre: ComodoRSAAddTrustCA.crt
- Certificado Intermedio 2. Ejemplo de nombre: ExtendedvalidationSecureServerCA.crt
- Certificado Intermedio 3. Ejemplo de nombre: ComodoSHA256SecureServerCA.crt
- Certificado emitido. Ejemplo de nombre: www.tuchance.org.crt

Para concatenar en la línea de comandos es posible hacerlo por medio del comando cat.

	cat OV_USERTrustRSACertificationAuthority.crt OV_NetworkSolutionsOVServerCA2.crt AddTrustExternalCARoot.crt > tuchance_org.ca-bundle

Luego el certificado emitido para el dominio:

	cat WWW.tuchance.org.crt tuchance_org.ca-bundle > ssl-bundle.crt

###Instalación de certificado

Es necesario modificar el archivo default-ssl, configurando el certificado y otros parámetros como los protocolos y cifrados a soportar. En este paso será necesario identificar si alguno de estos ha sido descontinuado o si ha sido identificado como vulnerable.

En caso que el archivo `/etc/ssl/certs/dhparam.pem` no exista deberemos ejecutar lo siguiente:

	cd /etc/ssl/certs
	openssl dhparam -out dhparam.pem 4096

Modificaremos nuestro archivo `/etc/nginx/sites-available/tuchance` a verse como el siguiente:

	server {
		listen 80;
		server_name tuchange.org www.tuchance.org;
		rewrite ^/(.*)$ https://tuchance.org/$1 permanent;
	}

	server {
		listen 443;
		server_name www.tuchance.org;
		rewrite ^/(.*)$ https://tuchance.org/$1 permanent;

		ssl on;
		ssl_certificate /home/tuchance/ssl/ssl-bundle.crt;
		ssl_certificate_key /home/tuchance/ssl/tuchance_org.key;
		ssl_session_timeout 5m;
		ssl_session_cache shared:SSL:5m;

		ssl_dhparam /etc/nginx/dhparam.pem;

		ssl_protocols TLSv1 TLSv1.1 TLSv1.2; # puede ser necesario remover o agregar alguno
		ssl_ciphers 'ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-SHA384:ECDHE-ECDSA-AES128-SHA256:ECDHE-RSA-AES256-SHA384:ECDHE-RSA-AES128-SHA256:ECDHE-RSA-AES256-SHA:ECDHE-ECDSA-AES256-SHA:ECDHE-RSA-AES128-SHA:ECDHE-ECDSA-AES128-SHA:DHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-SHA256:DHE-RSA-AES256-SHA:DHE-RSA-CAMELLIA256-SHA:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES128-SHA256:DHE-RSA-AES128-SHA:DHE-RSA-SEED-SHA:DHE-RSA-CAMELLIA128-SHA:HIGH:!aNULL:!eNULL:!LOW:!3DES:!MD5:!EXP:!PSK:!SRP:!DSS'; # puede ser necesario remover o agregar alguno
		ssl_prefer_server_ciphers on;
	}

	server {
		listen 443;

		server_name tuchance.org;

		proxy_set_header X-Forwarded-For $remote_addr;

		add_header Strict-Transport-Security "max-age=31536000; includeSubDomains";
		server_tokens off;

		access_log /home/tuchance/logs/nginx.access;
		error_log /home/tuchance/logs/nginx.error;

		index index.php index.html index.htm;

		root /home/tuchance/www/public;

		location / {
			try_files $uri $uri/ /index.php?$query_string;
		}

		location ~ \.php$ {
			try_files $uri /index.php =404;
			fastcgi_split_path_info ^(.+\.php)(/.+)$;
			fastcgi_read_timeout 150;
			fastcgi_pass unix:/var/run/php71-fpm-tuchance.sock;
			fastcgi_index index.php;
			fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
			include fastcgi_params;
		}

		ssl on;
		ssl_certificate /home/tuchance/ssl/ssl-bundle.crt;
		ssl_certificate_key /home/tuchance/ssl/tuchance_org.key;
		ssl_session_timeout 5m;
		ssl_session_cache shared:SSL:5m;

		ssl_dhparam /etc/nginx/dhparam.pem;

		ssl_protocols TLSv1 TLSv1.1 TLSv1.2; # puede ser necesario remover o agregar alguno
		ssl_ciphers 'ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-SHA384:ECDHE-ECDSA-AES128-SHA256:ECDHE-RSA-AES256-SHA384:ECDHE-RSA-AES128-SHA256:ECDHE-RSA-AES256-SHA:ECDHE-ECDSA-AES256-SHA:ECDHE-RSA-AES128-SHA:ECDHE-ECDSA-AES128-SHA:DHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-SHA256:DHE-RSA-AES256-SHA:DHE-RSA-CAMELLIA256-SHA:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES128-SHA256:DHE-RSA-AES128-SHA:DHE-RSA-SEED-SHA:DHE-RSA-CAMELLIA128-SHA:HIGH:!aNULL:!eNULL:!LOW:!3DES:!MD5:!EXP:!PSK:!SRP:!DSS'; # puede ser necesario remover o agregar alguno
		ssl_prefer_server_ciphers on;
	}
