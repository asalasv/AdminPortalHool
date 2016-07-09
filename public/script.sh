#!/bin/bash
mkdir hola
# # echo 'id_cliente: '$1
# # echo 'minutos: '$2
# # echo 'horas: '$3
# # echo 'dia: '$4
# # echo 'mes: '$5
# # echo 'id_portal_cliente: '$6
# RUTA="/root/temporal"
# id_equipo=`mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "select id_equipo from clientes where id_cliente='$1';"`
# hostname=`mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "select hostname from equipos where id_equipo='$id_equipo';"`
# #foto_publicidad=`mysql -h localhost -u root -pQu3l4d.114. -D portalhook -sN -e "select imagen_publicidad from portales_cliente where id_portal_cliente='$1';"`
# foto_publicidad=`mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "select imagen_publicidad from portales_cliente where id_cliente='$1' and id_portal_cliente='$6';"`
# #foto_logo=`mysql -h localhost -u root -pQu3l4d.114. -D portalhook -sN -e "select imagen_logo from portales_cliente where id_portal_cliente='$1';"`
# foto_logo=`mysql -h vps.portalhook.com -u root -pQu3l4d.114. -D portalhook -sN -e "select imagen_logo from portales_cliente where id_portal_cliente='$1' and id_portal_cliente='$6';"`
# echo $hostname
# cp /var/www/html/AdminPH/public/images/$foto_publicidad /tmp/$1-$6-captiveportal-logo.png
# cp /var/www/html/AdminPH/public/images/$foto_logo /tmp/$1-$6-captiveportal-logonuevo2.png
# ssh root@$hostname -p 22010 'mkdir -p /root/temporal/$1-$6'
# ssh root@$hostname -p 22010 'mkdir -p /root/scripts'
# scp -p 22010 /tmp/$1-$6-captiveportal-logo.png root@$hostname:$RUTA/$1-$6/captiveportal-logo.png
# scp -p 22010 /tmp/$1-$6-captiveportal-logonuevo2.png root@$hostname:$RUTA/$1-$6/captiveportal-logonuevo2.png
# ssh root@$hostname -p 22010 'echo "$2 $3 $4 $5 * /root/scripts/script-$1-$6" | crontab -'
# ssh root@$hostname -p 22010 'echo "cp /root/temporal/$1-$6/* /usr/local/captiveportal" > /root/scripts/script-$1-$6'
# ssh root@$hostname -p 22010 'echo "rm -rf /root/temporal/$1-$6/*" >> /root/scripts/script-$1-$6'
# ssh root@$hostname -p 22010 'chmod 777 /root/scripts/script-$1-$6'
# rm -rf /tmp/$1-$6-*
