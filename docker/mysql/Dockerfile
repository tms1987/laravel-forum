FROM mysql:5.7

ENV MYSQL_ROOT_PASSWORD=secret
ENV MYSQL_DATABASE=tests
ENV MYSQL_USER=tests
ENV MYSQL_PASSWORD=secret

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 3306 33060
CMD ["mysqld"]