# rpc-test

##Requirements:
- Docker
- Composer

##Setup:

- Run the following commands
```
git clone https://github.com/pukkancs/rpc-test.git rpc-test
cd rpc-test
```

- Add to hosts file:
```
127.0.0.1       rpc-test.dev
```

- Fire up docker
```
docker-compose up
```

- Install project dependencies

```
docker exec rpctest_php_1 bash -c 'composer install -d /code'
```

##Usage:

- Import RPC-Test.postman_collection.json into PostMan 
- Fire the requests. (you can modify or add your own aswell)

##Unit and integration tests:
```
docker exec rpctest_php_1 bash -c '/code/vendor/bin/phpunit /code/tests'
```