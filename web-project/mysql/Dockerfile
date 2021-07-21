FROM mysql:5.7
RUN chown -R mysql:root /var/lib/mysql/

ENV MYSQL_CONNECTION=mysql
ENV MYSQL_HOST=nubium-sanbox.test
ENV MYSQL_PORT=3306
ENV MYSQL_DATABASE=nette
ENV MYSQL_USER=dev2
ENV MYSQL_PASSWORD=dev2
ENV MYSQL_ROOT_PASSWORD=root

ADD 01-tables.sql /etc/mysql/01-tables.sql
ADD 02-data.sql /etc/mysql/02-data.sql
RUN sed -i 's/MYSQL_DATABASE/'$MYSQL_DATABASE'/g' /etc/mysql/01-tables.sql
RUN sed -i 's/MYSQL_DATABASE/'$MYSQL_DATABASE'/g' /etc/mysql/02-data.sql
#RUN cp /etc/mysql/docker-entrypoint-initdb.d

EXPOSE 3306