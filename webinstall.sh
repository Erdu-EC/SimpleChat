#Agregando repositorios.
sudo add-apt-repository ppa:ondrej/php
sudo wget -c https://dev.mysql.com/get/mysql-apt-config_0.8.17-1_all.deb
sudo dpkg -i mysql-apt-config_0.8.17-1_all.deb
sudo rm mysql-apt-config_0.8.17-1_all.deb

#Instalando software importante.
sudo apt-get update
sudo apt-get install apache2 php7.4 mysql-server -y
sudo apt-get install ffmpeg

#Configurando base de datos.
sudo mysql -u root -e "update mysql.user set plugin = 'mysql_native_password' where User = 'root'"
sudo service mysql restart
mysql -u root < bd.sql

#Copiando los ficheros de la aplicación al servidor.
sudo rm -r /var/www/SimpleChat
sudo cp -r $(pwd) /var/www/SimpleChat

#Configurando host virtual.
sudo rm /etc/apache2/sites-available/SimpleChat.com.conf
sudo cp SimpleChat.com.conf /etc/apache2/sites-available/SimpleChat.com.conf
sudo cp -r ssl /etc/apache2

#Habilitando host virtual.
sudo a2ensite SimpleChat.com.conf
sudo service apache2 restart

#Estableciendo permisos en el servidor.
cd /var/www/SimpleChat
sudo chmod u+x webpermissions.sh
$(pwd)/webpermissions.sh