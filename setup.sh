#!/bin/bash

cd proxy
cp .env.sample .env
sh ./start.sh
cd ..


cd api

cp .env.prod .env
cp docker-compose.prod.yml docker-compose.yml

docker-compose pull
docker-compose up -d --force-recreate
sleep 15
docker-compose exec php chown -R www-data:www-data /var/www/
docker-compose exec --user=www-data php composer install
docker-compose exec --user=www-data php bin/console doctrine:schema:update --force
docker-compose exec --user=www-data php bin/console doctrine:schema:validate
docker-compose exec --user=www-data php composer install --no-dev -o
docker-compose exec --user=www-data php composer dump-autoload --optimize --no-dev --classmap-authoritative
docker-compose exec --user=www-data php php bin/console cache:clear

cd ..

cd client
cp .env.prod .env

# build
cp docker-compose.dev.yml docker-compose.yml
docker-compose pull
docker-compose up -d --force-recreate
docker-compose exec nginx yarn install
docker-compose exec nginx yarn run build
docker-compose down

# start
cp docker-compose.prod.yml docker-compose.yml
docker-compose pull
docker-compose up -d --force-recreate
cd ..
