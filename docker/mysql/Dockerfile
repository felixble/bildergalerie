FROM mysql:5.7
ENV MYSQL_ROOT_PASSWORD dev
ENV MYSQL_USER dev
ENV MYSQL_PASSWORD dev
USER root
ADD . /setup
WORKDIR /setup
RUN chmod u+x ./init_db.sh
RUN ./init_db.sh