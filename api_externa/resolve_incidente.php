<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

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
?>
