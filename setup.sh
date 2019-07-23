#!/bin/bash

cd proxy
cp .env.sample .env
docker network rm webproxy
docker network create webproxy
sh ./start.sh
cd ..


cd client

# for production environment
# cp .env.prod .env

# for dev environment
cp .env.dist .env

# build
cp docker-compose.dev.yml docker-compose.yml
docker-compose pull
docker-compose up -d --force-recreate
docker-compose exec nginx yarn install
docker-compose exec nginx yarn run build
docker-compose down

# start
# for production environment
# cp docker-compose.prod.yml docker-compose.yml

# for dev environment
cp docker-compose.dist.yml docker-compose.yml

docker-compose pull
docker-compose up -d --force-recreate
cd ..


cd api

# for production environment
# cp .env.prod .env
# cp docker-compose.prod.yml docker-compose.yml

# for dev environment
cp .env.dist .env
cp docker-compose.dist.yml docker-compose.yml


docker-compose pull
docker-compose up -d --force-recreate
sleep 15

openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
openssl rsa -in config/jwt/private.pem -out config/jwt/private2.pem
mv config/jwt/private.pem config/jwt/private.pem-back
mv config/jwt/private2.pem config/jwt/private.pem

docker-compose exec php chown -R www-data:www-data /var/www/
docker-compose exec --user=www-data php composer install
docker-compose exec --user=www-data php bin/console doctrine:schema:update --force
docker-compose exec --user=www-data php bin/console doctrine:schema:validate
docker-compose exec --user=www-data php composer install --no-dev -o
docker-compose exec --user=www-data php composer dump-autoload --optimize --no-dev --classmap-authoritative
docker-compose exec --user=www-data php php bin/console cache:clear

cd ..
