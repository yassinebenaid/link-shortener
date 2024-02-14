#!/bin/bash

echo 'Clonning .env.example to .env ...'
cp .env.example .env.example

echo "Installing composer dependencies ..."
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

echo "Running containers ..."
./vendor/bin/sail up -d

echo "Generating app key ..."
./vendor/bin/sail artisan key:generate

echo "Installing NPM modules ..."
./vendor/bin/sail npm update

echo "Building Frontend Assets ..."
./vendor/bin/sail npm run build

if [ -f "./public/hot" ]; then
    rm ./public/hot
fi

echo "Running migrations ..."
./vendor/bin/sail artisan migrate:fresh --seed

echo "Clear cached files ..."
./vendor/bin/sail artisan optimize:clear


echo "
---------------------------------------------------------------------------------
    The Application is up and running.
    Visit:  http://localhost

    Use these credentials to Login:
        email    :  ysbenaid@gmail.com
        password :  password

    To Stop the application run:
        ./vendor/bin/sail down

    To Start it again:
        ./vendor/bin/sail up -d
---------------------------------------------------------------------------------
"
