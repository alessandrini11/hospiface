# Installation
- Clone the project
- get the .env file
- Download and install [composer](https://getcomposer.org/download/)
- Download ans install [symfony Cli](https://symfony.com/download)
- install project dépendencies `composer install`
## Project setup
### Database setup
- Edit `.env` pour to add environment variables
- DATABASE_URL="mysql://`db_user`:`db_password`@127.0.0.1:3306/`db_name`"
- create database `symfony console d:d:c`
- execute migrations `symfony console d:m:m`
- create a default user with admin role `symfony console d:f:l`
- generate SSL key to generate jwt on authentication `php bin/console lexik:jwt:generate-keypair`
### run web server
- `symfony serve`
