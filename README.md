# webservice
Symfony webservice template

## Installation
This webservice can be copied with the [Composer](https://getcomposer.org/) dependency manager.

1. [Install Composer](https://getcomposer.org/doc/00-intro.md)

2. Create project

        composer create-project free2er/webservice my-service
        cd my-service

3. Copy the OAuth public key or create new one

        cd keys
        openssl genrsa -out private.key 2048
        openssl rsa -in private.key -pubout -out public.key

4. Check code style and tests

        composer lint
        composer test

5. Done!

        symfony serve
        curl localhost:8000
        curl -H "Authorization: Bearer your.jwt.key" localhost:8000/api/v1/user

## Docker

1. Install 
        [Docker](https://docs.docker.com/install/) and 
        [Docker Compose](https://docs.docker.com/compose/install/)

2. Create project

        git clone git@github.com:free2er/webservice.git
        cd webservice

3. Copy the OAuth public key or create new one

        cd keys
        openssl genrsa -out private.key 2048
        openssl rsa -in private.key -pubout -out public.key

4. Check code style and tests

        docker-compose run fpm composer lint
        docker-compose run fpm composer test

5.  Done!

        docker-compose up
        curl localhost:8000
        curl -H "Authorization: Bearer your.jwt.key" localhost:8000/api/v1/user
