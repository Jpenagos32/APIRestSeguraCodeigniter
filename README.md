# Aplicación usada para probar la implementación de JWT

1. la aplicacion debe generar un token para eso instalamos:

   - firebase/php-jwt: `composer require firebase/php-jwt`

2. En el archivo .env agregar (mejor si se usa una variable de entorno, para mas seguridad):
    - `JWT_SECRET_KEY=$2a$10$9G66WoMZDDmJygdwiCJLl.rtfoZkObCi9yIoRqbta0utgX5TrZ3ta`
    - `JWT_TIME_TO_LIVE=3600` (hace referencia al tiempo de vida del token) 
3. Dentro del archivo `App/Config/Services.php` agregamos una funcion que nos permita 
obtener las variables de entorno de JWT

4.  Crear un helper que ayude a obtener y firmar el JWT dentro de `/app/Helpers`

5. Crear filtros para poder proteger las rutas en `app/Filters/JWTAuthFilter.php`
6. En el archivo `app/Config/Filters.php` registrar el filtro con un nuevo alias para poder ser usado para ello
se agrega  en el arrreglo `$aliases`
7. En el arreglo `$filters` del archivo `app/Config/Filters.php` agregar el filtro creado en el punto 6
dandole una propiedad `before` y las rutas a las cuales se debe aplicar el filtro.
ejemplo:
   ```php
   public array $filters = [
    // Agregar el filtro "auth" antes de ingresar a los endpoints
    'auth' => [
      'before' => [
        //rutas que tendrán filtro
        'client/*', 
        'client'
      ]
    ]
   ];
   ```

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
