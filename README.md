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
php bin/console doctrine:schema:update --force
php bin/console server:start
```

Browse to : [http://localhost:8000/](http://localhost:8000/)