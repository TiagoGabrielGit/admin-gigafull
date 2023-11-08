
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$query_api = "SELECT active
FROM api
WHERE id = 8";

$query_api = $pdo->prepare($query_api);
$query_api->execute();
$result_api = $query_api->fetch(PDO::FETCH_ASSOC);

if ($result_api['active'] == 1) {

    $ip = $_SERVER['REMOTE_ADDR'];

    $query_ip = "SELECT count(*) as qtde
FROM api_externa_ip
WHERE api_id = 8 and ip = :ip";

    $stmt_ip = $pdo->prepare($query_ip);
    $stmt_ip->bindParam(':ip', $ip, PDO::PARAM_STR);
    $stmt_ip->execute();
    $result_ip = $stmt_ip->fetchAll(PDO::FETCH_ASSOC);

    if ($result_ip[0]['qtde'] > 0) {

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
    } else {
        echo "IP $ip não autorizado";
    }
} else {
    echo "API não habilitada";
}
