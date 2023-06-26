<?php
require "../../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $transceiverID = $_POST['transceiverID'];
    $patrimonioTransceiver = $_POST['patrimonioTransceiver'];
    $nSerieTransceiver = $_POST['nSerieTransceiver'];

    $sql = "INSERT INTO produtos_transceiver_units (produto_transceiver_id, patrimonio, n_serie, active, created, disponibilidade) VALUES (?, ?, ?, '1', NOW(), '1')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$transceiverID, $patrimonioTransceiver, $nSerieTransceiver]);

    // Verifica se o registro foi inserido com sucesso
    if ($stmt->rowCount() > 0) {
        $id = $pdo->lastInsertId(); // Obtém o último ID inserido
        header("Location: /cadastros/produtos/produtos/view_transceiver.php?id=$transceiverID");
        exit;
    } else {
        header("Location: /cadastros/produtos/produtos/view_transceiver.php?id=$transceiverID");
        exit;
    }
}
