#!/usr/bin/env bash

VM_SYNC_FOLDER='/vagrant_data'

# make sure .env exists; if not, copy the sample config file
if [ ! -f ${VM_SYNC_FOLDER}/.env ]; then
    cp ${VM_SYNC_FOLDER}/.env.sample ${VM_SYNC_FOLDER}/.env
fi

dos2unix /vagrant_data/.env
dos2unix /vagrant_data/vagrant/read-env.sh

. ${VM_SYNC_FOLDER}/vagrant/read-env.sh

MYSQL_USER=${DB_USER}
MYSQL_PW=${DB_PASS}

echo ${MYSQL_USER} ${MYSQL_PW}

sudo echo "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"  | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}

# run composer and install dependencies
cd ${VM_SYNC_FOLDER}
composer install
