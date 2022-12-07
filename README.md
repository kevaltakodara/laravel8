Please follow this setps 
1) kindly create .env file from .env.example
    cp .env.example .env

2) composer install
3) npm install
4) change your database setting in .env file

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE={database_name}
    DB_USERNAME=root
    DB_PASSWORD=

5) php artisan migrate
