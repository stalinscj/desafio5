# Desafio5


## _The best place for manage your tasks_

Desafio5 is a web app that allows to you manage tasks.

## Features

- _Test Driven Development (TDD)._
- Create tasks.
- List tasks.
- Show task detail.
- Edit tasks.
- Delete tasks.
- Add logs tasks and send notifications.
- Assign users to tasks.


## Technologies

- [Laravel 8] - Laravel is a web application framework with expressive, elegant syntax.
- [MySQL] - MySQL is the world's most popular open source database.
- [PHP] - PHP is a popular general-purpose scripting language that is especially suited to web development.
- [PHPUnit] - PHPUnit is a programmer-oriented testing framework for PHP.

- [Bootstrap] - The world’s most popular framework for building responsive, mobile-first sites.


## Installation

```sh
git clone https://github.com/stalinscj/desafio5.git
```

```sh
cd desafio5
```

```sh
composer install
```

(If it was not copied automatically after installation):

```sh
cp .env.example .env
```

(If it was not generated automatically after installation):

```sh
php artisan key:generate
```

From MySQL CLI:

```sh
CREATE DATABASE db_name;
```

In .env file set the following variables:

```sh
APP_NAME=
APP_URL=

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
```

```sh
php artisan migrate
```

If everything is ok then all tests should pass:

```sh
php artisan test
```

```sh
php artisan serve
```

In your browser go to http://127.0.0.1:8000


[//]: # (Links) 

[Laravel 8]: <https://laravel.com>
[MySQL]: <https://www.mysql.com>
[PHP]: <https://www.php.net>
[PHPUnit]: <https://phpunit.de>
[Bootstrap]: <https://getbootstrap.com>
