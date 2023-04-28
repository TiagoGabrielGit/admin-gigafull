<?php
require "../../../conexoes/conexao.php";

$idOLT = $_GET['idOLT'];
$slotOLT = $_GET['slotOLT'];
$ponOLT = $_GET['ponOLT'];
$idONU = $_GET['idONU'];
$LAN1 = $_GET['LAN1'];
$LAN2 = $_GET['LAN2'];
$LAN3 = $_GET['LAN3'];
$LAN4 = $_GET['LAN4'];

$captura_dados_olt =
    "SELECT 
rno.olt_ipAddress as ipOLT,
rno.olt_username as userOLT,
rno.olt_password as passOLT
FROM
redeneutra_olts as rno
WHERE
rno.id = $idOLT
";

$r_dados_olt = mysqli_query($mysqli, $captura_dados_olt);
$campos_dados_olt = $r_dados_olt->fetch_array();

$ipOLT = $campos_dados_olt['ipOLT'];
$userOLT = $campos_dados_olt['userOLT'];
$passOLT = $campos_dados_olt['passOLT'];

exec("bash ../../../bash/olt/huawei/addTAG.bash $ipOLT $userOLT $passOLT $slotOLT $ponOLT $idONU '$LAN1' '$LAN2' '$LAN3' '$LAN4'", $retorno1);