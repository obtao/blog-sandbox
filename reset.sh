#!/bin/bash
set -e
cd `php -r "echo dirname(realpath('$0'));"`

if [ ! -f composer.phar ]; then
    echo "- download composer.phar"
    curl -s http://getcomposer.org/installer | php
fi

if [ ! -d vendor ]; then
    echo "- install dependencies"
    php composer.phar install
fi

echo "- drop database"
php app/console doctrine:database:drop --force || true
php app/console fos:elastica:reset

echo "- create database"
php app/console doctrine:database:create
echo "- create SQL schema"
php app/console doctrine:schema:create

echo "- load fixtures in project"
php app/console doctrine:fixtures:load --append

#echo "- indexing objects"
#php app/console fos:elastica:populate

echo "- Install assets"
php app/console assets:install web --symlink

echo "- production assets"
php app/console assetic:dump --env=prod --no-debug web || true
