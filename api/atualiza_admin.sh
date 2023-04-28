#!/bin/bash
data=$(date +'%d%m%Y')
hora=$(date +'%H%M%S')
pasta=dev
mkdir /var/www/bkp_$data-$hora
sleep 5
cp -r /var/www/$pasta.gigafull.com.br/* /var/www/bkp_$data-$hora
sleep 10
wget https://github.com/TiagoGabrielGit/admin-gigafull/archive/refs/heads/master.zip
sleep 20
unzip master.zip
sleep 10
cp -r admin-gigafull-master/* /var/www/$pasta.gigafull.com.br/
sleep 10
rm -r master.zip admin-gigafull-master/
sleep 10
cp /var/www/bkp_$data-$hora/conexoes/conexao.php /var/www/$pasta.gigafull.com.br/conexoes/
sleep 10
cp /var/www/bkp_$data-$hora/conexoes/conexao_pdo.php /var/www/$pasta.gigafull.com.br/conexoes/
sleep 10
cp /var/www/bkp_$data-$hora/assets/img/logo.png /var/www/$pasta.gigafull.com.br/assets/img/
sleep 10
cp /var/www/bkp_$data-$hora/api/atualiza_admin.sh /var/www/$pasta.gigafull.com.br/api/
sleep 10
echo "Finish";