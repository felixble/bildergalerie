#!/bin/bash 
cd $( cd "$(dirname "${BASH_SOURCE[0]}")" ; pwd -P )

TARGET_FOLDER="jasteuer@stl-s-stud.htwsaar.de:/export/home_16/jasteuer/public_html/sqe/screenshots"
FINAL_BASE_LINK="http://www1.htwsaar.de/~jasteuer/sqe/screenshots"
FINAL_TUNNEL_LINK="localhost:9000/~jasteuer/sqe/screenshots"
 
if [ -d "../screenshots" ]; then 
    echo "uploading screenshots to: $FINAL_BASE_LINK"; 
    echo "                          $FINAL_TUNNEL_LINK"; 
    scp -i id_rsa -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -r "../screenshots" $TARGET_FOLDER 
fi
