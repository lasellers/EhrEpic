## EHR Epic

It has been a while since I've started a brand-new Laravel project from scratch,
especially one that has nothing to do with work. Which means I have little in
the way of my own Laravel projects to play around with for testing things.
So this is a bit of a refresher and a place to experiment with a few things.
Will build a React frontend for it later on.

THIS IS NOT MEANT TO BE A FUNCTIONAL PROJECT

### Installation

* sudo apt install php7.4-cli
* composer locally
* sudo apt install php-zip php-mbstring php-dom phpunit php-mysql

 php composer.phar install
 php artisan --version

    php artisan key:generate
    php artisan cache:clear
    php artisan route:clear

 php artisan serve

npm i

docker run --name ehrepic -e MYSQL_ROOT_PASSWORD=password -d mariadb:latest


php composer.php migrate
php composer.php dump-autoload
php artisan db:seed

or
php artisan migrate:fresh --seed


## 
https://hub.docker.com/r/reachfive/fake-smtp-server
sudo docker pull reachfive/fake-smtp-server
sudo docker run -d -name ehrsmtp reachfive/fake-smtp-server
sudo docker exec -it ehrsmtp /bin/bash

sudo docker kill ehrsmtp


## Tests

Note: Since we have setup this project from the start to use Laravel migrations
we can do a:

`php artisan migration:refresh --seed`

and completely refresh the database to initial values.
 
This also applies to tests -- they can automatically refresh after each test.

Trust me -- I've had to build complicated Test Fixture workarounds to keep
track of everything in projects where we had legacy data from before migration to
a Laravel stack. This is much easier. :) 


## Unit
`./vendor/bin/phpunit tests/Unit`

Tests against single methods without a database.

## Integration
`./vendor/bin/phpunit tests/Integration`

Tests against various methods that may call other methods across classes with the database.

## Functional
`./vendor/bin/phpunit tests/Functional`

At this level, tests against the API specs. 
See Javascript E2E for others.

## Browser (Dusk)

`./vendor/bin/phpunit tests/Browser`

Other functional tests, against Blade templates.
See Javascript E2E for others.
