<?php
require "../../../../conexoes/conexao_pdo.php";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fabricante = $_POST['fabricante'];
    $modelo = $_POST['modeloComponente'];
    $descricao = $_POST['descricaoComponente'];


    $sql = "INSERT INTO produtos_componentes (fabricante_id, modelo, descricao, active) VALUES (?, ?, ?, '1')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fabricante, $modelo, $descricao]);

    // Verifica se o registro foi inserido com sucesso
    if ($stmt->rowCount() > 0) {
        $id = $pdo->lastInsertId(); // Obtém o último ID inserido
        header("Location: /cadastros/produtos/produtos/view_componentes.php?id=$id");
        exit;
    } else {
        header("Location: /cadastros/produtos/produtos/index.php");
        exit;
    }
}
