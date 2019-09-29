#!/usr/bin/env bash

envFile=.env

# check preconditions
if [ ! -f ${envFile} ]; then
    echo "Your environment is not set up correctly! Move the .env.example to .env, and edit your database (DB_*)" \
            "credentials."
fi


# set up environment variables from .env-file
while read line   # iterate over lines
do
    if [ ! -z ${line}  ]; then
        declare -x  "${line}"
    fi
done <<< "$(cat ${envFile})" # this makes sure that the loop will not be executed in a subshell

MYSQL_USER=${DB_USER}
MYSQL_PW=${DB_PASS}
MYSQL_DB=${DB_DATABASE}

# Setup database
sudo echo "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"  | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
sudo echo "DROP DATABASE IF EXISTS sqe_bildergalerie" | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
sudo echo "CREATE DATABASE sqe_bildergalerie" | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
sudo mysql --user=${MYSQL_USER} --password=${MYSQL_PW} ${MYSQL_DB} < ./Datenmodell/bildergalerie.sql