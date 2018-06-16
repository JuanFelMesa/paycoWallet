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

```
php bin console doctrine:database:create
```

Paso 5

```
php bin console doctrine:schema:update --force
```

Paso 5

```
php bin console doctrine:fixtures:load --append
```



## Probando la aplicación




