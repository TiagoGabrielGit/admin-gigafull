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


$gpon_slot = isset($gponParts[1]) ? $gponParts[1] : '';
$gpon_pon = isset($gponParts[2]) ? $gponParts[2] : '';

// Consulta para obter o pon_id com base em gpon_slot, gpon_pon e hostID
$cap_id_pon_query = "SELECT gpp.id
                         FROM gpon_pon AS gpp
                         LEFT JOIN gpon_olts AS gpo ON gpo.id = gpp.olt_id
                         WHERE gpp.slot = :gpon_slot
                         AND gpp.pon = :gpon_pon
                         AND gpo.equipamento_id = :hostID";

$stmt_cap_id_pon = $pdo->prepare($cap_id_pon_query);
$stmt_cap_id_pon->bindParam(':gpon_slot', $gpon_slot);
$stmt_cap_id_pon->bindParam(':gpon_pon', $gpon_pon);
$stmt_cap_id_pon->bindParam(':hostID', $hostID);
$stmt_cap_id_pon->execute();
$pon_id_row = $stmt_cap_id_pon->fetch(PDO::FETCH_ASSOC);
$pon_id = $pon_id_row['id'];

$sql_new_incidente =
    "INSERT INTO incidentes (zabbix_event_id, equipamento_id, descricaoIncidente, classificacao, inicioIncidente, active, incident_type, gpon_slot, gpon_pon, pon_id)
    VALUES (:zabbix_event_id, :equipamento_id, :descricaoIncidente,:classificacao, NOW(), '1', :incidentType, :gpon_slot, :gpon_pon, :pon_id)";
$stmt = $pdo->prepare($sql_new_incidente);
$stmt->bindParam(':equipamento_id', $hostID);
$stmt->bindParam(':descricaoIncidente', $descricaoIncidente);
$stmt->bindParam(':zabbix_event_id', $zabbixEventID);
$stmt->bindParam(':classificacao', $classificacao);
$stmt->bindParam(':incidentType', $incidentType);
$stmt->bindParam(':gpon_slot', $gpon_slot);
$stmt->bindParam(':gpon_pon', $gpon_pon);
$stmt->bindParam(':pon_id', $pon_id);
$stmt->execute();
