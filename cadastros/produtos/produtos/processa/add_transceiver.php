<?php
require "../../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fabricante = $_POST['fabricante'];
    $modeloTransceiver = $_POST['modeloTransceiver'];
    $descricaoTransceiver = $_POST['descricaoTransceiver'];

    $sql = "INSERT INTO produtos_transceiver (fabricante_id, modelo, descricao, active) VALUES (?, ?, ?, '1')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fabricante, $modeloTransceiver, $descricaoTransceiver]);

    // Verifica se o registro foi inserido com sucesso
    if ($stmt->rowCount() > 0) {
        $id = $pdo->lastInsertId(); // Obtém o último ID inserido
        header("Location: /cadastros/produtos/produtos/view_transceiver.php?id=$id");
        exit;
    } else {
        header("Location: /cadastros/produtos/produtos/index.php");
        exit;
    }
}
