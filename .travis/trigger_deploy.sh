#!/bin/bash


if [ ${TRAVIS_BRANCH} != "develop" ]; then
    echo "Skip deployment. Not on develop branch."
    exit
fi

echo "Trigger deployment..."
curl "http://deploy.hildes-bildergalerie.de/?token=${deploy_token}"
