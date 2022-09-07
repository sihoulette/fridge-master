<h1 align="center">Fridge Master API</h1>

INTRODUCTION
------------
This project is the result of a test task. Please follow the installation instructions

INSTALLATION
------------
### Clone repository
You can then clone this project repository using the following command in domain directory root:
~~~
git clone git@github.com:sihoulette/laravel-fridge-master.git . 
~~~

### Install via Composer
If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project using the following command in domain directory root:
~~~
composer install
~~~

CONFIGURATION
-------------
### Generate application encryption key
You must generate application encryption key, please using the following command in domain directory root:
~~~
php artisan key:generate
~~~

### Database
Edit the file `.env` with real data, for example:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

MIGRATIONS
-------------
Apply database migrations, using the following command in domain directory root:
~~~
php artisan migrate
~~~

SEEDERS
-------------
Apply database seeders, using the following command in domain directory root:
~~~
php artisan db:seed
~~~
