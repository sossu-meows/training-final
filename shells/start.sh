#!/usr/bin/env bash

pwd

#it will be used for start docker purpose.
if [ ! -f "_docker/.env" ]; then
    echo "copied _docker/.env._docker.dist to _docker/.env"
    cp _docker/.env.example _docker/.env
fi

if [ ! -f "_docker/nginx/conf.d/lec2.conf" ]; then
    echo "copied _docker/nginx/conf.d.dist/lec2.conf to _docker/nginx/conf.d/lec2.conf"
    cp _docker/nginx/conf.d.dist/lec2.conf  _docker/nginx/conf.d/lec2.conf
fi

if [ ! -d "_docker/mariadb/datadir" ]; then
    echo "copied _docker/database.dist to _docker/database"
    cp -r _docker/mariadb/datadir.dist _docker/mariadb/datadir
fi

cd _docker

docker-compose build
docker-compose up -d
docker ps | grep -i lec2
