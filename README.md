8lol
====

A Symfony project created on May 22, 2017, 11:44 pm.

## Installation

```bash
git clone https://github.com/pierreflaudias/9gag.git && cd 9gag
```

```bash
docker run -d \
    --volume /var/lib/mysql \
    --name data_mysql \
    --entrypoint /bin/echo \
    busybox "mysql data-only container"
```

```bash
docker run -d -p 3306 \
    --name mysql \
    --volumes-from data_mysql \
    -e MYSQL_USER=root \
    -e MYSQL_PASS=root \
    -e ON_CREATE_DB=8lol \
    tutum/mysql
```

```bash
composer install
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php bin/console server:start
```

Browse to : [http://localhost:8000/](http://localhost:8000/)

## Tests

```bash
phpunit
```

## Routes for API

#### GET &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/api/ -> list LOLs
#### GET &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/api/meme/{id} -> one specific LOL
#### DELETE &nbsp;&nbsp;/api/meme/{id}/remove -> remove one specific LOL
#### DELETE &nbsp;&nbsp;/api/meme/{id}/comment/{comment_id} -> remove one specific comment for one specific  LOL
#### POST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/api/meme -> create a LOL
#### POST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/api/meme/{id}/comment -> create a comment for one specific LOL
#### GET &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/api/meme/{id}/{note} -> note a specific LOL
#### POST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/api/register -> register a new user
#### GET &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/api/user -> get information for the user sending token
