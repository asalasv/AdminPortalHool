#!/bin/bash

# id_equipo=`mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "select id_equipo from clientes where id_cliente='$1';"`
# hostname=`mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "select noip from equipos where id_equipo='$id_equipo';"`

# mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "delete from sesiones where id_equipo='$id_equipo';"

# ssh root@$hostname -p 22010 "echo 'select * from captiveportal;' |/usr/local/bin/sqlite3 /var/db/captiveportalportalhook.db" > /tmp/$hostname
# IFS=$'\n'
# for linea in $(cat /tmp/$hostname); do
# 	IP=`echo $linea  | awk -F "|" '{print $3}'`
# 	USUARIO=`echo $linea | awk -F "|" '{print $5}'`
# 	SESION=`echo $linea | awk -F "|" '{print $6}'`
# 	mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "insert into sesiones (id_equipo, ip, usuario, sesion) values ('$id_equipo' , '$IP' , '$USUARIO' , '$SESION');"
# done