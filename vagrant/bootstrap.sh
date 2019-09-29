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
MYSQL_DB=${DB_DATABASE}

# setup default sites-available
NGINX=$(cat <<EOF
server {
	listen 80 default_server;
	listen [::]:80 default_server;

	# set client body size
    client_max_body_size 5M;

	root ${VM_SYNC_FOLDER};

	# Add index.php to the list if you are using PHP
	index index.php index.html index.htm index.nginx-debian.html;

	server_name _;

	location / {
		try_files \$uri \$uri/ @rewrites;
	}

	location @rewrites {
                rewrite ^ /index.php last;
        }

	location ~ \.php$ {
        	include snippets/fastcgi-php.conf;
        	fastcgi_pass unix:/run/php/php7.0-fpm.sock;
    	}
}
EOF
)
sudo echo "${NGINX}" > /etc/nginx/sites-available/default
sudo ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

sudo sed -i -e 's/sendfile on/sendfile off/' /etc/nginx/nginx.conf

# reload nginx config
sudo nginx -s reload

# Setup database
sudo echo "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"  | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
sudo echo "DROP DATABASE IF EXISTS sqe_bildergalerie" | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
sudo echo "CREATE DATABASE sqe_bildergalerie" | \
    mysql --user=${MYSQL_USER} --password=${MYSQL_PW}
sudo mysql --user=${MYSQL_USER} --password=${MYSQL_PW} ${MYSQL_DB} < ${VM_SYNC_FOLDER}/Datenmodell/bildergalerie.sql