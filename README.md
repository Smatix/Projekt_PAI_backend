# Zaparkuj auto - backend

It is application to search parking, booking place and monitoring time and actual cost.

In this project I tried to apply DDD approach and separate the write from the read.

### How to run

Create .env file with configuration
Create database
Install dependencies using
```
composer install
```
Generate key
```
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
Run migrations
```
php bin/console doctrine:migrations:migrate
```

### How to run tests
```
php bin/phpunit
```