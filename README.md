# Android APK
We added a self signed app-release.apk to the repo. It points to the demo server. You can see Mercure auto updating in the app. (note, we only put Mercure ont he book show page, not the list)

# Summary
I was looking for a tutorial, or solution to learn from which had a few of the elements I think are key to most apps. 
* multi tenant/teams
* scope of data by team
* secured live data updates
* app setup
* messenger added for background data

Since I couldn't find on I decided to post on upwork, and open source the result. I met Maksym: https://www.upwork.com/freelancers/~01f4204dd14c8f6973 a very bright coder, who pulled this together in record time, above and beyond expectation. I hope open sourcing this can help others who want to get onto the apiplatform (and Mercure) bandwagon

# Basic Preparation
1) make sure no apache or nginx installed
2) make sure docker installed also docker-compose tool should be installed
3) clone the repo
4) run sh ./setup
5) docker ps to see all containers running
6) if after install any containers didn't start, cd api && docker-compose stop && rm -rf var/log/* && docker-compose up -d

# how to prepare for real time communication
look for and replace instances of the demo domain. Please be sure DNS is done first, as it will be needed by certbox for SSL

# proxy
set up your external IP in .env file

# for api folder
* api/docker-compose.yml:      VIRTUAL_HOST: apidemo.yap.life
* api/docker-compose.yml:      LETSENCRYPT_HOST: apidemo.yap.life
* api/docker-compose.yml:      - VIRTUAL_HOST=mercuredemo.yap.life
* api/docker-compose.yml:      - LETSENCRYPT_HOST=mercuredemo.yap.life
* api/docker-compose.prod.yml:      VIRTUAL_HOST: apidemo.yap.life
* api/docker-compose.prod.yml:      LETSENCRYPT_HOST: apidemo.yap.life
* api/docker-compose.prod.yml:      - VIRTUAL_HOST=mercuredemo.yap.life
* api/docker-compose.prod.yml:      - LETSENCRYPT_HOST=mercuredemo.yap.life

# client folder
* client/docker-compose.prod.yml:      VIRTUAL_HOST: clientdemo.yap.life
* client/docker-compose.prod.yml:      LETSENCRYPT_HOST: clientdemo.yap.life
* client/docker-compose.yml:      VIRTUAL_HOST: clientdemo.yap.life
* client/docker-compose.yml:      LETSENCRYPT_HOST: clientdemo.yap.life

# mobile folder
* .env.prod:VUE_APP_API_URL='https://apidemo.yap.life'
* .env.prod:VUE_APP_MERCURE_URL='https://mercuredemo.yap.life/hub'

# proxy
nginx/data/conf.d/default.conf << setup all your domains

# note
passphrase !ChangeMe!  << can be changed in env.prod

# mobile app
* clone same repo to your local machine
* in client folder, yarn install && yarn build
* install cordova
* install needed emulators and SDKs
* cp .env.prod .env
* in mobile folder, yarn install && yarn build
* cd src-cordova
* cordova platform add ios (or other)
* cordova run ios (or replace ios with other)

# demo
https://apidemo.yap.life/
https://clientdemo.yap.life/
