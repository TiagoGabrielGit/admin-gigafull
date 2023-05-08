<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$ipHost = $_GET["ipHost"];
$descricaoIncidente = $_GET["descricaoIncidente"];
$zabbixEventID = $_GET["eventID"];
$classificacao = "0";

$sql_dados_equipamento =
    "SELECT
eqpop.id as idEquipamento
FROM
equipamentospop as eqpop
WHERE
eqpop.ipaddress = '$ipHost'
and
eqpop.deleted = 1
";

$consulta = mysqli_query($mysqli, $sql_dados_equipamento);
$result = mysqli_fetch_assoc($consulta);
$idEquipamento = $result['idEquipamento'];

if ($idEquipamento == "") {
    $idEquipamento = "0";
    $sql_new_incidente =
        "INSERT INTO redeneutra_incidentes (zabbix_event_id, equipamento_id, descricaoIncidente, classificacao, inicioIncidente, active)
    VALUES (:zabbix_event_id, :equipamento_id, :descricaoIncidente, :classificacao, NOW(), '1')";
    $stmt = $pdo->prepare($sql_new_incidente);
    $stmt->bindParam(':equipamento_id', $idEquipamento);
    $stmt->bindParam(':descricaoIncidente', $descricaoIncidente);
    $stmt->bindParam(':zabbix_event_id', $zabbixEventID);
    $stmt->bindParam(':classificacao', $classificacao);
    $stmt->execute();
    $idIncidente = $pdo->lastInsertId();

    if ($idIncidente <> "0") {
        echo "Incidente $idIncidente gerado, sem equipamento vinculado!";
    }
} else {
    $sql_new_incidente =
        "INSERT INTO redeneutra_incidentes (zabbix_event_id, equipamento_id, descricaoIncidente, classificacao, inicioIncidente, active)
    VALUES (:zabbix_event_id, :equipamento_id, :descricaoIncidente,:classificacao, NOW(), '1')";
    $stmt = $pdo->prepare($sql_new_incidente);
    $stmt->bindParam(':equipamento_id', $idEquipamento);
    $stmt->bindParam(':descricaoIncidente', $descricaoIncidente);
    $stmt->bindParam(':zabbix_event_id', $zabbixEventID);
    $stmt->bindParam(':classificacao', $classificacao);
    $stmt->execute();
    $idIncidente = $pdo->lastInsertId();

    if ($idIncidente <> "0") {
        echo "Incidente $idIncidente gerado!";
    }
}
