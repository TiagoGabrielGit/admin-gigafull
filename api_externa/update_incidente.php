
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$updateMessage = $_GET["updateMessage"];
$zabbixEventID = $_GET["eventID"];

$sql_dados_incidente =
    "SELECT id as idIncidente FROM incidentes WHERE zabbix_event_id = $zabbixEventID";

$consulta = mysqli_query($mysqli, $sql_dados_incidente);
$result = mysqli_fetch_assoc($consulta);
$idIncidente = $result['idIncidente'];


if ($idIncidente) {
    $sql_update_incidente =
        "INSERT INTO incidentes_relatos (incidente_id, relato, horarioRelato)
    VALUES (:incidente_id, :relato, NOW())";
    $stmt = $pdo->prepare($sql_update_incidente);
    $stmt->bindParam(':incidente_id', $idIncidente);
    $stmt->bindParam(':relato', $updateMessage);
    $stmt->execute();
    $idIncidente = $pdo->lastInsertId();
}