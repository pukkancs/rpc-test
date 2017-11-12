# rpc-test

##Requirements:
- PHP 7.1 newer with mbscript extension
- Docker
- Composer

##Setup:

- Run the following commands
```
git clone https://github.com/pukkancs/rpc-test.git rpc-test
cd rpc-test
composer install -d code
```

- Add to hosts file:
```
127.0.0.1       rpc-test.dev
```

- Fire up docker
```
docker-compose up
```
##Usage:

- Import RPC-Test.postman_collection.json into PostMan 
- Fire the requests. (you can modify or add your own aswell)

##Unit and integration tests:
```
./code/vendor/bin/phpunit ./code/tests/
```