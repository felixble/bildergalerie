#!/usr/bin/env bash

MYSQL_USER='root'
MYSQL_PW='dev'
MYSQL_DB='prooph'

service mysql start

DB_CMD=$(cat <<EOF
echo "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"  | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
EOF
)

echo "${DB_CMD}" >> ~/.bashrc

echo "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"  | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
echo "DROP DATABASE IF EXISTS ${MYSQL_DB}" | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
echo "CREATE DATABASE ${MYSQL_DB}" | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
mysql --user=${MYSQL_USER} --password=${MYSQL_PW} ${MYSQL_DB} < ./bildergalerie.sql