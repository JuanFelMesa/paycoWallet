# PaycoWallet

Este es un desarrollo de prueba para PAYCO

## Notas iniciales:

Este proyecto está diseñado para correr en un ambiente LAMP

### Prerequisitos

Debe tener instalado:

```
Composer
MySql Server
NodeJs
NPM
Express
```

### Instalación

Este es el proceso de instalación para correr la aplicacion server SOAP

Paso 1

```
git clone https://github.com/ju4nr3v0l/paycoWallet.git
```

Paso 2

```
cd /xml
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




