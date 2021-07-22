FROM mysql:5.7

ENV MYSQL_CONNECTION=mysql
ENV MYSQL_HOST=nubium-sanbox.test
ENV MYSQL_PORT=3306
ENV MYSQL_DATABASE=nette
ENV MYSQL_USER=dev
ENV MYSQL_PASSWORD=dev
ENV MYSQL_ROOT_PASSWORD=root

ENV LANG=C.UTF-8

ADD 01-tables.sql /docker-entrypoint-initdb.d/01-tables.sql
ADD 02-data.sql /docker-entrypoint-initdb.d/02-data.sql
RUN sed -i 's/MYSQL_DATABASE/'$MYSQL_DATABASE'/g' /docker-entrypoint-initdb.d/01-tables.sql
RUN sed -i 's/MYSQL_DATABASE/'$MYSQL_DATABASE'/g' /docker-entrypoint-initdb.d/02-data.sql
#RUN cp /etc/mysql/docker-entrypoint-initdb.d

EXPOSE 3306