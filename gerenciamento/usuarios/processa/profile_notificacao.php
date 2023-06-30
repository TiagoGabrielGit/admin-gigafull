<?php

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require  "../../../conexoes/conexao_pdo.php";

    // Recupera o valor do radio button selecionado
    $status = $_POST['notificaEmail'];
    $id = $_POST['idUsuario'];

    // Define o estado de ativação com base no valor do radio button
    $ativo = ($status == 1) ? 1 : 0;

    // Atualiza o estado de ativação do cadastro no banco de dados
    $updateSql = "UPDATE usuarios SET notify_email = :ativo WHERE id = :id";
    $stmtUpdate = $pdo->prepare($updateSql);
    $stmtUpdate->bindParam(':ativo', $ativo);
    $stmtUpdate->bindParam(':id', $id);
    $stmtUpdate->execute();

    // Redireciona para a página de visualização dos convites
    header("Location: /gerenciamento/usuarios/profile.php?id=$id");
    exit();
}
