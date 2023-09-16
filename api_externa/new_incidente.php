<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";


$descricaoIncidente = $_GET["descricaoIncidente"];
$zabbixEventID = $_GET["eventID"];
$incidentType =  $_GET["incidentType"];
$classificacao = "0";
$hostID =  $_GET["hostID"];
$gponPON = isset($_GET["gponPON"]) ? $_GET["gponPON"] : '';

// Dividir a string em partes usando o "/"
$gponParts = explode("/", $gponPON);

// Definir gpon_slot e gpon_pon com base nas partes da string
$gpon_slot = isset($gponParts[1]) ? $gponParts[1] : '';
$gpon_pon = isset($gponParts[2]) ? $gponParts[2] : '';

$sql_new_incidente =
    "INSERT INTO incidentes (zabbix_event_id, equipamento_id, descricaoIncidente, classificacao, inicioIncidente, active, incident_type, gpon_slot, gpon_pon)
    VALUES (:zabbix_event_id, :equipamento_id, :descricaoIncidente,:classificacao, NOW(), '1', :incidentType, :gpon_slot, :gpon_pon)";
$stmt = $pdo->prepare($sql_new_incidente);
$stmt->bindParam(':equipamento_id', $hostID);
$stmt->bindParam(':descricaoIncidente', $descricaoIncidente);
$stmt->bindParam(':zabbix_event_id', $zabbixEventID);
$stmt->bindParam(':classificacao', $classificacao);
$stmt->bindParam(':incidentType', $incidentType);
$stmt->bindParam(':gpon_slot', $gpon_slot);
$stmt->bindParam(':gpon_pon', $gpon_pon);
$stmt->execute();
