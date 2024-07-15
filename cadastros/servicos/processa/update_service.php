<?php
session_start();

if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Obter dados do formulário
    $id = $_POST['id'];
    $servico = $_POST['servico'];
    $ativo = $_POST['ativo'];
    $permite_item = $_POST['permite_item'];
    $descricao = $_POST['descricao'];

    // Consulta para atualizar os dados do serviço
    $sql = "UPDATE service SET service=:servico, description=:descricao, item_service=:permite_item, active=:ativo WHERE id=:id";
    $stmt = $pdo->prepare($sql);

    // Vincular parâmetros
    $stmt->bindParam(':servico', $servico, PDO::PARAM_STR);
    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $stmt->bindParam(':permite_item', $permite_item, PDO::PARAM_INT);
    $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Executar consulta e verificar se foi bem-sucedida
    if ($stmt->execute()) {
        header("Location: /cadastros/servicos/view_service.php?id=$id");
        exit();
    } else {
        header("Location: /cadastros/servicos/view_service.php?id=$id");
        exit();
    }
} else {
    echo "Acesso negado.";
}
