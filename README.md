# simple-api-test

It is a simple test of API using Lumen.
Tried to keep it simple, assuming that all inputs are valid.

Requeriments: 

- PHP >= 7.2.5
- Composer

OR

- Docker
- Docker compose

Instructions for PHP:

```sh
$ cd api
$ composer install --no-dev
$ php artisan migrate:refresh
$ php -S 0.0.0.0:8000 -t public
```

Instructions for Docker:

```sh
$ cd docker
$ docker-compose up
```

The api will be avalible at http://0.0.0.0:8000/