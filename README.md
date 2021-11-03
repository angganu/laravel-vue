# SMM Test

## Silahkan lakukan tahapan berikut untuk menggunakan

``` bash
# buka console lalu clone repository terlebih dahulu
$ git clone git@github.com:angganu/laravel-vue.git
```

## Lakukan konfigurasi env dan buat database

* copy file `.env.example` menjadi `.env`
* buat database di mysql dengan nama `test_angganu`
* ubah konfigurasi file `.env` sebagai berikut 
``` bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_angganu
DB_USERNAME=root
DB_PASSWORD=
```
* untuk konfigurasi database bisa disesuaikan kembali dengan yang diinginkan.

## Lakukan instalasi melalui console

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

# login menggunakan akun berikut
mail: user1@user.com `-hingga-` user10@user.com
pass: password
# akun user digunakan untuk melihat fitur test smm
```

## CATATAN

* source code ini menggunakan template dari `coreui`
* php yang digunakan menggunakan versi 7.3
* database menggunakan mysql
