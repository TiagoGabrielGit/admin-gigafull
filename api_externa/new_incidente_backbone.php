<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$descricaoIncidente = $_GET["descricaoIncidente"];
$zabbixEventID = $_GET["eventID"];
$incidentType =  $_GET["incidentType"];
$classificacao = "0";
$hostID =  $_GET["hostID"];

$sql_new_incidente =
    "INSERT INTO incidentes (zabbix_event_id, equipamento_id, descricaoIncidente, classificacao, inicioIncidente, active, incident_type, envio_com_normalizacao)
    VALUES (:zabbix_event_id, :equipamento_id, :descricaoIncidente,:classificacao, NOW(), '1', :incidentType, '0')";
$stmt = $pdo->prepare($sql_new_incidente);
$stmt->bindParam(':equipamento_id', $hostID);
$stmt->bindParam(':descricaoIncidente', $descricaoIncidente);
$stmt->bindParam(':zabbix_event_id', $zabbixEventID);
$stmt->bindParam(':classificacao', $classificacao);
$stmt->bindParam(':incidentType', $incidentType);
if ($stmt->execute()) {
    $response['ID do Incidente'] = $pdo->lastInsertId(); // Obtém o último ID inserido

    $response['Retorno da Chamada'] = "Incidente Aberto";
} else {
    $response['Retorno da Chamada'] = "Falha ao abrir incidente";
}
echo json_encode($response);
