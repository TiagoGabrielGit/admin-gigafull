<?php
require "../../../../conexoes/conexao_pdo.php";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipamento = $_POST['equipamento'];
    $fabricante = $_POST['fabricante'];

    $sql = "INSERT INTO equipamentos (equipamento, fabricante, deleted, criado) VALUES (?, ?, '1', now())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$equipamento, $fabricante]);

    // Verifica se o registro foi inserido com sucesso
    if ($stmt->rowCount() > 0) {
        $id = $pdo->lastInsertId(); // Obtém o último ID inserido
        header("Location: /cadastros/produtos/produtos/view_equipamentos.php?id=$id");
        exit;
    } else {
        header("Location: /cadastros/produtos/produtos/index.php");
        exit;
    }
}
