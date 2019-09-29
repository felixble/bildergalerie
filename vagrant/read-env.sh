#!/usr/bin/env bash


VM_SYNC_FOLDER='/vagrant_data'

envFile=${VM_SYNC_FOLDER}/.env

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