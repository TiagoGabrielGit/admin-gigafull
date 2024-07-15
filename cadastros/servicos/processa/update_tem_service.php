<?php
session_start();

if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Obter dados do formulário
    $itemID = $_POST['id'];
    $item = $_POST['item'];
    $activeEditar = $_POST['ativo'];
    $codIntEdit = !empty($_POST['int_Code']) ? $_POST['int_Code'] : null;
    $descricaoItemEdit = $_POST['descricao'];

    // Consulta para atualizar os dados do item de serviço
    $sql = "UPDATE iten_service SET item=:item, integration_code=:codIntEdit, description=:descricaoItemEdit, active=:activeEditar WHERE id=:itemID";
    $stmt = $pdo->prepare($sql);

    // Vincular parâmetros
    $stmt->bindParam(':item', $item, PDO::PARAM_STR);
    $stmt->bindParam(':codIntEdit', $codIntEdit, PDO::PARAM_STR);
    $stmt->bindParam(':descricaoItemEdit', $descricaoItemEdit, PDO::PARAM_STR);
    $stmt->bindParam(':activeEditar', $activeEditar, PDO::PARAM_INT);
    $stmt->bindParam(':itemID', $itemID, PDO::PARAM_INT);

    // Executar consulta e verificar se foi bem-sucedida
    if ($stmt->execute()) {
        header("Location: /cadastros/servicos/view_itemservice.php?id=$itemID");
        exit();
    } else {
        header("Location: /cadastros/servicos/view_itemservice.php?id=$itemID");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
