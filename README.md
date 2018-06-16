# PaycoWallet

Este es un desarrollo de prueba para PAYCO

## Notas iniciales:

Este proyecto está diseñado para correr en un ambiente LAMP

### Prerrequisitos

Debe tener instalado:

```
Composer
MySql Server
NodeJs
NPM
Express
Linux
PHP
Apache
```

### Instalación

Se recomienda trabajar con virtual hosts debido a que esta aplicación está desarrollada con symfony 4.0

Ejemplo de virtual host:

```
<VirtualHost *:80>
    ServerName nombre del servidor dado en /etc/hosts
    ServerAlias alias (recomendado el mismo ServerName)
    DocumentRoot /Ruta/Hasta/El/Proyecto/paycoTest/soap/public
    <Directory /Ruta/Hasta/El/Proyecto/paycoTest/soap/public>
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
Este es el proceso de instalación para correr la aplicacion server SOAP

Paso 1

```
git clone https://github.com/ju4nr3v0l/paycoWallet.git
```

Paso 2

```
cd /soap
```

Paso 3

```
composer install
```

Paso 3

```
composer update
```

Paso 4

En la raiz del proyecto modificar en el archivo .env la linea que se describe a continuación con sus datos de conexión a su servidor MySql y el nombre de la base de datos

```
DATABASE_URL=mysql://usuario:contraseña@127.0.0.1:3306/baseDeDatos
```


Paso 5

```
php bin console doctrine:database:create
```

Paso 6

```
php bin console doctrine:schema:update --force
```

Paso 7

```
php bin console doctrine:fixtures:load --append
```



## Probando la aplicación




