# Famous Quote Quiz
A project built on Symfony MVC + VueJS. Docker is being used for local development.

To get it working, follow these steps:

**Download Composer dependencies**

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```
composer install
```

You may alternatively need to run `php composer.phar install`, depending
on how you installed Composer.

**Database Setup**

```
docker-compose up -d
```

Next, build the database, execute the migrations and load the fixtures with:

```
# "symfony console" is equivalent to "bin/console"
# but its aware of your database container
symfony console doctrine:database:create --if-not-exists
symfony console doctrine:schema:update --force
symfony console doctrine:fixtures:load
```

**Start the Symfony web server**

You can use Nginx or Apache, but Symfony's local web server
works even better.

To install the Symfony local web server, follow
"Downloading the Symfony client" instructions found
here: https://symfony.com/download - you only need to do this
once on your system.

Then, to start the web server, open a terminal, move into the
project, and run:

```
symfony serve -d --allow-http
```

Then run:
```
yarn dev-server
```
