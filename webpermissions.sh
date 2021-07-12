SERVER_DIR=$(pwd)
USER=$(whoami)

cd ..

#Eliminando directorios y ficheros temporales del proyecto.
sudo rm -r ${SERVER_DIR}/.temp

#Establiendo grupo propietario y añadiendo usuario al grupo.
sudo chgrp -R www-data ${SERVER_DIR}
sudo usermod -a -G www-data ${USER}

#Permisos de los ficheros y directorios.
sudo chmod -R 750 ${SERVER_DIR}
sudo chmod 770 ${SERVER_DIR}
sudo find ${SERVER_DIR} -type f -exec chmod 740 {} \;

#Propietario de los ficheros.
sudo chown -R ${USER} ${SERVER_DIR}

#Instalando modulos.
sudo apt-get install php-gd -y
sudo apt-get install php7.4-mysql -y

#Habilitando modulos.
sudo a2enmod rewrite
sudo a2enmod php7.4
echo "extension=pdo_mysql" | sudo tee -a /etc/php/7.4/apache2/php.ini

#Reiniciando servidor.
sudo service apache2 restart

echo Terminado
