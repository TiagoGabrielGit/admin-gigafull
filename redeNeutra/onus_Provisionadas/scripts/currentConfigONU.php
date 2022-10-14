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

exec("bash ../../../bash/olt/huawei/currentConfigONU.bash $ipOLT $userOLT $passOLT $slotOLT $ponOLT $idONU", $retorno1);

$array_result = [];
foreach ($retorno1 as $key => $value) {

    $pos1 = strpos($value, '[gpon]');
    if ($pos1 !== false) {
        $array_result1[] = $key;
    }

    $pos2 = strpos($value, 'return');
    if ($pos2 !== false) {
        $array_result2[] = $key;
    }
}

$linhaInicial = $array_result1[0];

$linhaFinal = $array_result2[0];

for ($linhaInicial; $linhaInicial <= $linhaFinal; $linhaInicial++) {
    echo $retorno1[$linhaInicial]  . PHP_EOL;
}


//print_r($posicoes);

/*foreach ($retorno1 as $key1) {

    echo $key1 . PHP_EOL;
    
}*/
 
/*exec("bash ../../bash/add_onu.bash $ipOLT $userOLT $passOLT $slotOLT $ponOLT $serialONU $line_profile_id $srv_profile_id $descricaoONU", $retorno1);

$linha = $retorno1[36];
$posicao = strpos($linha, 'ONTID :');
$idONU = substr($linha, $posicao + 7);

echo "PON | ID:" . $linha . PHP_EOL;
echo $posicao . PHP_EOL;
echo "ID ONU:" . $idONU . PHP_EOL;

echo "=============" . PHP_EOL;

exec("bash ../../bash/service_port.bash $ipOLT $userOLT $passOLT $CVLAN $slotOLT $ponOLT $idONU $SVLAN $SVLAN", $retorno2);
exec("bash ../../bash/consulta_service-port.bash $ipOLT $userOLT $passOLT $slotOLT $ponOLT $idONU", $retorno3);
$r3 = $retorno3[33];
$valida3 = strpos($r3, "Failure");

foreach ($retorno1 as $key1) {
    echo $key1 . "\n";
}

foreach ($retorno2 as $key2) {
    echo $key2 . "\n";
}

if ($valida3 === false) {
    $sql_insert = "INSERT INTO redeneutra_onu_provisionadas (olt_id, parceiro_id, descricao, slot_olt, pon_olt, id_onu, serial_onu)
    VALUES ('$olt', '$parceiro', '$descricaoONU', '$slotOLT', '$ponOLT', '$idONU', '$serialONU')";
    mysqli_query($mysqli, $sql_insert);
}*/