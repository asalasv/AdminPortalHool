#!/bin/bash
mkdir $1
mkdir $2

# id_equipo=`mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "select id_equipo from clientes where id_cliente='$1';"`
# hostname=`mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "select noip from equipos where id_equipo='$id_equipo';"`

# ssh root@$hostname -p 22010 "php /usr/local/bin/desconexion.php $2"