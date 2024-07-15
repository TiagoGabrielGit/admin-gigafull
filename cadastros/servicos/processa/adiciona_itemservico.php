<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    $cadItem = $_POST['cadItem'];
    $cadItemCodInt = isset($_POST["cadItemCodInt"]) ? $_POST["cadItemCodInt"] : null;
    $descricaoItem = $_POST['descricaoItem'];
    $active = "1";
    $cont_insert = false;

    $sql_insert_servico = "INSERT INTO iten_service (item, description, active) VALUES (:item, :description, :active)";
    $stmt1 = $pdo->prepare($sql_insert_servico);
    $stmt1->bindParam(':item', $cadItem);
    $stmt1->bindParam(':description', $descricaoItem);
    $stmt1->bindParam(':active', $active);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        header("Location: /cadastros/produtos/servicos/itens_servicos.php");
        exit();
    } else {
        header("Location: /cadastros/produtos/servicos/itens_servicos.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
