<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$idOLT = $_GET["idOLT"];
$service = $_GET["service"];
$parceiro = $_GET["parceiro"];
$CVLAN = $_GET["CVLAN"];
$SVLAN = $_GET["SVLAN"];
$GEMPORT = $_GET["GEMPORT"];
$lineProfile = $_GET["lineProfile"];
$srvProfile = $_GET["srvProfile"];

//Cria evento na tabela auxiliar
$sql_perfil =

"INSERT INTO redeneutra_profile_parceiro (service, redeneutra_parceiro_id, redeneutra_olt_id, CVLAN, SVLAN, GEMPORT, line_profile_id, srv_profile_id, active)
VALUES (:service, :redeneutra_parceiro_id, :redeneutra_olt_id, :CVLAN, :SVLAN, :GEMPORT, :line_profile_id, :srv_profile_id, '1')";

$stmt = $pdo->prepare($sql_perfil);
$stmt->bindParam(':service', $service);
$stmt->bindParam(':redeneutra_parceiro_id', $parceiro);
$stmt->bindParam(':redeneutra_olt_id', $idOLT);
$stmt->bindParam(':CVLAN', $CVLAN);
$stmt->bindParam(':SVLAN', $SVLAN);
$stmt->bindParam(':GEMPORT', $GEMPORT);
$stmt->bindParam(':line_profile_id', $lineProfile);
$stmt->bindParam(':srv_profile_id', $srvProfile);


$stmt->execute();
