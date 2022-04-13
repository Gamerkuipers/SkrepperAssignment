# Instruction to setup Symfony

## Requirements

- [PHP](https://www.php.net/downloads)
  - With extension: [Ctype](https://www.php.net/book.ctype), [iconv](https://www.php.net/book.iconv), [PCRE](https://www.php.net/book.pcre), [Session](https://www.php.net/book.session), [SimpleXML](https://www.php.net/book.simplexml), [Tokenizer](https://www.php.net/book.tokenizer)
- [Composer](https://getcomposer.org/download/)
- [Symfony CLI](https://symfony.com/download)
- [nodeJS](https://nodejs.org/en/)

## Instructions

1. Run "composer install"
2. Set up a database user in your desired database with the rights to create a database, I used [postgresql](https://www.postgresql.org/download/) (instructions to set up postgresql below)
3. copy the .env to .env.local "copy .env .env.local"
4. and enter your database details ([example](https://symfony.com/doc/current/doctrine.html#configuring-the-database))
  - for postgresql i will look like this: **DATABASE_URL="postgresql://*your_user*:*your_pass*@127.0.0.1:5432/database_name?serverVersion=13&charset=utf8"**
5. Run "php bin/console doctrine:database:create"
6. Run "php bin/console doctrine:migrations:migrate" and choose yes (is default)
7. Run "symfony server:start" you can add "-d" to the end to start it detached from the console
8. Run "npm install"
9. Run "npm run build"
10. WooHoo the application is running and can be used to its fullest

## Using the endpoints

To use api endpoints use [postman](https://www.postman.com/) or [insomnia](https://insomnia.rest/download) or a different one (I only know these) because all requests are POST requests
to get started create an account at "/register" and then login at "/login" and at "/user" click "create apikey" to create an apikey and then use your *username* and *apikey* to communicate with the api

*currently, I use a temporary apikey generator (name + amount of api keys)*

### Available API endpoints
to use any endpoint you need to give "username" and "apikey" in the body
- (REQUIRED) string - username
- (REQUIRED) string - apikey


- (POST) api/address - get all records
- (POST) api/address/{id} - get one record
  - id = int
- (POST) /address/create - create a record
  - string - name
  - (optional) string - phoneNumber (default: null)
  - (optional) string - description (default: null)

## How to set up postgresql with user

First you gotta have [postgresql](https://www.postgresql.org/download/) installed.
After installing open postgresql command line in windows open "sql shell (psql)", Login in postgresql.

now let's create a user "create user *your_user* with password '*your_password*';" (password is surrounded with single quotes).
lets give them rights to create a database "alter user *your_user* createDB;"

now our user is set to be used in symfony.