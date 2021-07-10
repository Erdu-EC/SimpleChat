#!/bin/bash

SERVER_DIR=$(pwd)
USER=$(whoami)

cd ..

#Establiendo grupo propietario y añadiendo usuario al grupo.
sudo chgrp -R www-data ${SERVER_DIR}
sudo usermod -a -G www-data ${USER}

#Permisos de los ficheros y directorios.
sudo chmod -R 750 ${SERVER_DIR}
sudo chmod 770 ${SERVER_DIR}
sudo find ${SERVER_DIR} -type f -exec chmod 740 {} \;

#Propietario de los ficheros.
sudo chown -R ${USER} ${SERVER_DIR}

#Habilitando modulos.
sudo a2enmod rewrite

echo Terminado
