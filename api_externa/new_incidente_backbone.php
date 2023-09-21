<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";


$descricaoIncidente = $_GET["descricaoIncidente"];
$zabbixEventID = $_GET["eventID"];
$incidentType =  $_GET["incidentType"];
$classificacao = "0";
$hostID =  $_GET["hostID"];

$sql_new_incidente =
    "INSERT INTO incidentes (zabbix_event_id, equipamento_id, descricaoIncidente, classificacao, inicioIncidente, active, incident_type)
    VALUES (:zabbix_event_id, :equipamento_id, :descricaoIncidente,:classificacao, NOW(), '1', :incidentType)";
$stmt = $pdo->prepare($sql_new_incidente);
$stmt->bindParam(':equipamento_id', $hostID);
$stmt->bindParam(':descricaoIncidente', $descricaoIncidente);
$stmt->bindParam(':zabbix_event_id', $zabbixEventID);
$stmt->bindParam(':classificacao', $classificacao);
$stmt->bindParam(':incidentType', $incidentType);
$stmt->execute();
