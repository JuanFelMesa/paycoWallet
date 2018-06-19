# PaycoWallet

Este es un desarrollo de prueba para PAYCO

## Notas iniciales:

Este proyecto está diseñado para correr en un ambiente LAMP con Symfony 4.0

### Prerrequisitos

Debe tener instalado:

```
Composer
MySql Server
Linux
PHP < 5.X
Apache server
```

### Instalación


Este es el proceso de instalación para correr la aplicacion server SOAP

Se recomienda trabajar con virtual hosts debido a que esta aplicación está desarrollada con symfony 4.0

Ejemplo de virtual host:
(este archivo se crea en /etc/apache2/sites-aviable y se crea un enlace simbólico en /etc/apache2/sites-enabled, luego de modificar estos archivos se debe reiniciar el servicio de apache)

```
<VirtualHost *:80>
    ServerName nombre del servidor dado en /etc/hosts
    ServerAlias alias (recomendado el mismo ServerName)
    DocumentRoot /Ruta/Hasta/El/Proyecto/paycoWallet/soap/public
    <Directory /Ruta/Hasta/El/Proyecto/paycoWallet/soap/public>
        AllowOverride None
        Order Allow,Deny
        Allow from All

        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ index.php [QSA,L]
        </IfModule>
    </Directory>

    # uncomment the following lines if you install assets as symlinks
    # or run into problems when compiling LESS/Sass/CoffeeScript assets
    # <Directory /var/www/project>
    #     Options FollowSymlinks
    # </Directory>

    ErrorLog /var/log/apache2/project_error.log
    CustomLog /var/log/apache2/project_access.log combined

    # optionally set the value of the environment variables used in the application
    #SetEnv APP_ENV prod
    #SetEnv APP_SECRET <app-secret-id>
    #SetEnv DATABASE_URL "mysql://db_user:db_pass@host:3306/db_name"
</VirtualHost>

```

Paso 1

```
git clone https://github.com/ju4nr3v0l/paycoWallet.git
```

Paso 2

```
cd /paycoWallet/soap
```

Paso 3

```
composer install
```

Paso 4

```
composer update
```

Paso 5

En la raiz del proyecto modificar en el archivo .env la linea que se describe a continuación con sus datos de conexión a su servidor MySql y el nombre de la base de datos

```
DATABASE_URL=mysql://usuario:contraseña@127.0.0.1:3306/baseDeDatos
```


Paso 6

```
php bin/console doctrine:database:create
```

Paso 7

```
php bin/console doctrine:schema:update --force
```





## Probando la aplicación

Esta es la doc de la API

```
https://web.postman.co/collections/2689877-a7097e89-ebab-4627-937a-92de689539a6?workspace=2e09dd1b-432b-4d69-8fa1-187fbf21788a
```

Usando los endPoints con los ejemplos se puede iniciar el testeo de la app.


