# laravel-vue-todos
doing fancy with vue + laravel 


## setup api

* change into api folder
```console
$ cd api
```
* run composer install
```console
$ composer install
```
* create a new database in local environment
* copy .env.example to .env and change database - settings
```console
$ cp .env.example .env && vi .env
```
* run migration
```console
$ php artisan migrate
```
* (create a local host-entry for api to run on)

## for testing api
* run ./vendor/bin/phpunit in api-folder
```console
$ ./vendor/bin/phpunit
```

## run html
* change into html folder
```console
$ cd html
```
* change axios.defaults.baseURL to local host entry
```console
$ vi src/store/actions.js
```
* run webpack build
```console
$ npm run build
```
* run dev-server
```console
$ npm run dev
```

