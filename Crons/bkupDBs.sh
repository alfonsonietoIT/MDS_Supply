#!/bin/sh
NOW="$(date +"%Y%m%d")"

#Mueve a Folder Local
echo "Move to Local Folder..."
cd /
cd home/MDSMaster/BCkups/

#Creacion de Backups Base de Datos
echo "*** mds_warehouse Backup Creating..."
mysqldump -u root -p"MX4lb3rt0$" mds_warehouse | gzip -9 > $NOW-mds_warehouse.sql.gz
echo "*** mds_supply Backup Creating..."
mysqldump -u root -p"MX4lb3rt0$" mds_supply | gzip -9 > $NOW-mds_supply.sql.gz
echo "*** mds_airgain Backup Creating..."
mysqldump -u root -p"MX4lb3rt0$" mds_airgain | gzip -9 > $NOW-mds_airgain.sql.gz
echo "*** test_supply Backup Creating..."
mysqldump -u root -p"MX4lb3rt0$" test_supply | gzip -9 > $NOW-test_supply.sql.gz

echo "*** FTP Uploading..."
#Conexion a SoftwareDevelopment
ftp -v -n 166.62.60.135 <<END_OF_SESSION
user masterwork@softwaredevelopment.mx M4st3rW0rk1
cd Bckps
put $NOW-mds_warehouse.sql.gz
put $NOW-mds_supply.sql.gz
put $NOW-mds_airgain.sql.gz
put $NOW-test_supply.sql.gz

bye
END_OF_SESSION  

#Manda correo electronico


echo "Ready..."
