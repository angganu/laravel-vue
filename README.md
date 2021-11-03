# SMM Test

## Silahkan lakukan tahapan berikut untuk menggunakan

``` bash
# buka console lalu clone repository terlebih dahulu
$ git clone git@github.com:angganu/laravel-vue.git
```
## Buat Database dan lakukan instalasi melalui console

``` bash
# pindah ke directory project laravel
$ cd laravel-vue/laravel

# install laravel composer
$ composer install

# install npm dependencies
$ npm install

# generate laravel APP_KEY
$ php artisan key:generate

# generate jwt secret
$ php artisan jwt:secret

# run database migration and seed
$ php artisan migrate:refresh --seed

# pindah ke directory project vue
$ cd ../vue

# install npm dependencies
$ npm install
```
## Menjalankan Aplikasi

``` bash
# kembali ke laravel directory
$ cd ../laravel

# jalankan local server
$ php artisan serve
# backend server akan berjalan pada url http://localhost:8000

# kembali ke vue directory
$ cd ../vue

# jalankan local server
$ npm run serve
# frontend vue akan berjalan pada url http://localhost:8080
```