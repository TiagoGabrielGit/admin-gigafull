<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";


$query_api = "SELECT active
FROM api
WHERE id = 3";

$query_api = $pdo->prepare($query_api);
$query_api->execute();
$result_api = $query_api->fetch(PDO::FETCH_ASSOC);

if ($result_api['active'] == 1) {

    $ip = $_SERVER['REMOTE_ADDR'];

    $query_ip = "SELECT count(*) as qtde
FROM api_externa_ip
WHERE api_id = 3 and ip = :ip";

    $stmt_ip = $pdo->prepare($query_ip);
    $stmt_ip->bindParam(':ip', $ip, PDO::PARAM_STR);
    $stmt_ip->execute();
    $result_ip = $stmt_ip->fetchAll(PDO::FETCH_ASSOC);

    if ($result_ip[0]['qtde'] > 0) {

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
    } else {
        echo "IP $ip não autorizado";
    }
} else {
    echo "API não habilitada";
}
