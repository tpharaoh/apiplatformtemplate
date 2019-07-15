# Backend
 - cd api
 - cp .env.dist .env
 - docker-compose up -d
 - docker-compose exec --user=www-data php sh ./setup.sh

# Frontend
 - cd client
 - cp .env.dist .env
 - yarn install
 - yarn serve
