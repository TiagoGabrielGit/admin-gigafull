<?php
require "../../../conexoes/conexao.php";

$idOLT = $_GET['idOLT'];
$slotOLT = $_GET['slotOLT'];
$ponOLT = $_GET['ponOLT'];
$idONU = $_GET['idONU'];

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

exec("bash ../../../bash/olt/huawei/reiniciarONU.bash $ipOLT $userOLT $passOLT $slotOLT $ponOLT $idONU", $retorno1);

$array_result = [];
foreach ($retorno1 as $key => $value) {

    $pos1 = strpos($value, 'Command');
    if ($pos1 !== false) {

        $array_result1[] = $key;
    }

    $pos2 = strpos($value, 'quit');
    if ($pos2 !== false) {
        $array_result2[] = $key;
    }
}

$linhaInicial = $array_result1[0];

$linhaFinal = $array_result2[0];

for ($linhaInicial; $linhaInicial <= $linhaFinal; $linhaInicial++) {
    echo $retorno1[$linhaInicial]  . PHP_EOL;
}
