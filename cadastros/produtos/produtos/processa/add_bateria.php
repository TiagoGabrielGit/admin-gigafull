<?php
require "../../../../conexoes/conexao_pdo.php";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores enviados pelo formulário
    $fabricante = $_POST['fabricante'];
    $modeloBateria = $_POST['modeloBateria'];
    $tensaoBateria = $_POST['tensaoBateria'];
    $amperagemBateria = $_POST['amperagemBateria'];

    // Insira o código para validar e processar os dados aqui, se necessário

    // Insere os dados na tabela produtos_bateria
    $sql = "INSERT INTO produtos_bateria (fabricante_id, modelo, tensao, amperagem, active) VALUES (?, ?, ?, ?, '1')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fabricante, $modeloBateria, $tensaoBateria, $amperagemBateria]);

    // Verifica se o registro foi inserido com sucesso
    if ($stmt->rowCount() > 0) {
        $id = $pdo->lastInsertId(); // Obtém o último ID inserido
        header("Location: /cadastros/produtos/produtos/view_baterias.php?id=$id");
        exit;
    } else {
        header("Location: /cadastros/produtos/produtos/index.php");
        exit;
    }
}
