#!/usr/bin/env bash
cd /var/www/lec2.docker.elidev.info/
docker exec -i lec2_mariadb sh -c 'mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD"  lec2_dev ' >  ./shells/dummy-db.sql
docker exec -i lec2_php sh -c 'cd /var/www/lec2 && git add ./shells/dummy-db.sql &&  git commit -a -m "Database has been backed up successfully" && git push origin dev'
