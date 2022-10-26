<?php
require "../../conexoes/conexao.php";

$ipOLT = $_GET['ipOLT'];
$userOLT = $_GET['userOLT'];
$passOLT = $_GET['passOLT'];
$slotOLT = $_GET['slotOLT'];
$ponOLT = $_GET['ponOLT'];
$serialONU = $_GET['serialONU'];
$line_profile_id = $_GET['line_profile_id'];
$srv_profile_id = $_GET['srv_profile_id'];
$codigoParceiro = $_GET['codigoParceiro'];
$codigoReserva = $_GET['codigoReserva'];
$CVLAN = $_GET['CVLAN'];
$SVLAN = $_GET['SVLAN'];
$GEMPORT = $_GET['GEMPORT'];
$parceiro = $_GET['parceiro'];
$olt = $_GET['olt'];

$descricaoONU = $codigoParceiro . "_" . $codigoReserva;

exec("bash ../../bash/add_onu.bash $ipOLT $userOLT $passOLT $slotOLT $ponOLT $serialONU $line_profile_id $srv_profile_id $descricaoONU", $retorno1);

foreach ($retorno1 as $key => $value) {
    $posONTID = strpos($value, 'ONTID :');
    if ($posONTID !== false) {
        $array_result1[] = $key;
    }
}

$linhaONTID = $array_result1[0];
$linhaONTID = $retorno1[$linhaONTID];
$posicaoONTID = strpos($linhaONTID, 'ONTID :');
$idONU = substr($linhaONTID, $posicaoONTID + 7);

echo "ID ONU:" . $idONU . PHP_EOL;

echo "=============" . PHP_EOL;

exec("bash ../../bash/service_port.bash $ipOLT $userOLT $passOLT $CVLAN $slotOLT $ponOLT $idONU $SVLAN $SVLAN $GEMPORT", $retorno2);
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
    $sql_insert = "INSERT INTO redeneutra_onu_provisionadas (metodo, olt_id, parceiro_id, descricao, slot_olt, pon_olt, id_onu, serial_onu, active, data_provisionamento)
    VALUES ('1', '$olt', '$parceiro', '$descricaoONU', '$slotOLT', '$ponOLT', '$idONU', '$serialONU', '1', NOW())";
    mysqli_query($mysqli, $sql_insert);
    $idProvisionamento = mysqli_insert_id($mysqli);
}
