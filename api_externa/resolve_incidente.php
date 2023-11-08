<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$query_api = "SELECT active
FROM api
WHERE id = 7";

$query_api = $pdo->prepare($query_api);
$query_api->execute();
$result_api = $query_api->fetch(PDO::FETCH_ASSOC);

if ($result_api['active'] == 1) {

    $ip = $_SERVER['REMOTE_ADDR'];

    $query_ip = "SELECT count(*) as qtde
FROM api_externa_ip
WHERE api_id = 7 and ip = :ip";

    $stmt_ip = $pdo->prepare($query_ip);
    $stmt_ip->bindParam(':ip', $ip, PDO::PARAM_STR);
    $stmt_ip->execute();
    $result_ip = $stmt_ip->fetchAll(PDO::FETCH_ASSOC);

    if ($result_ip[0]['qtde'] > 0) {

        $zabbix_event_id = $_GET["eventID"];

        try {
            $sql = "UPDATE incidentes SET active=?, fimIncidente=NOW(), envio_com_normalizacao=? WHERE zabbix_event_id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['0', '0', $zabbix_event_id]);

            if ($stmt->rowCount() > 0) {
                // Atualização bem-sucedida
                //echo "Atualização realizada com sucesso.";
            } else {
                // Nenhuma linha foi afetada (nenhuma atualização realizada)
                //echo "Nenhum registro foi atualizado.";
            }
        } catch (PDOException $e) {
            // Erro na consulta
            echo "Erro na atualização: " . $e->getMessage();
        }
    } else {
        echo "IP $ip não autorizado";
    }
} else {
    echo "API não habilitada";
}
