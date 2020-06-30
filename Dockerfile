# docker-compose up --build
# docker exec -it healthprovider_database_1 /bin/bash
# docker ps --all
# docker images
# docker volume ls
# docker volume inspect healthprovider_dbdata
# docker-compose exec app php artisan key:generate
# docker-compose exec app php artisan optimize
# docker-compose exec app php artisan migrate --seed
FROM mariadb:latest
USER root

MAINTAINER Lewis Sellers

RUN apt-get update && apt-get -y upgrade
RUN apt-get install -y nano curl

RUN /bin/bash -c "/usr/bin/mysqld_safe --skip-grant-tables &" && \
  sleep 5 && \
  mysql -u root -e "CREATE DATABASE ehrepic" &&
  mysql -u root -e "CREATE USER 'admin' IDENTIFIED BY 'password';" &&
  mysql -u root -e "GRANT ALL ON ehrepic.* TO 'admin"
# && \
# mysql -u root mydb < /tmp/dump.sql
# ADD init_db.sh /tmp/init_db.sh
#RUN /tmp/init_db.sh
# WORKDIR /var/www

# volume
EXPOSE 3306

RUN "/bin/bash"
