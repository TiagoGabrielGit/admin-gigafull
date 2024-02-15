<?php
session_start();

// Verificar se o método da requisição é POST e se a sessão está ativa
if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {


    require_once("../../../conexoes/conexao_pdo.php");

    $tokenTelegram = $_POST['tokenTelegram'];
    $statusIntegracao = $_POST['statusIntegracao'];
    $id = '1'; // Seu ID de usuário, você pode alterar isso conforme necessário

    // Prepare a query de atualização
    $query = "UPDATE integracao_telegram SET token = :token, active = :status WHERE id = :id";

    // Preparar e executar a declaração
    $stmt = $pdo->prepare($query);

    // Vincular parâmetros
    $stmt->bindParam(':token', $tokenTelegram);
    $stmt->bindParam(':status', $statusIntegracao);
    $stmt->bindParam(':id', $id);

    // Executar a declaração
    if ($stmt->execute()) {
        header("Location: /integracao/telegram/index.php");
        exit();
    } else {
        header("Location: /integracao/telegram/index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
