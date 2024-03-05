<?php
session_start();
if (isset($_SESSION['id'])) {
    require "../../conexoes/conexao_pdo.php";
    $id_notificacao = $_GET['id'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a consulta SQL para atualizar o status da notificação
        $stmt = $pdo->prepare("UPDATE smart_notification SET status = 2 WHERE id = :id");

        // Execute a consulta com o ID da notificação
        $stmt->execute(array(':id' => $id_notificacao));

        // Redireciona de volta para a página de origem do usuário
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } catch (PDOException $e) {
        // Em caso de erro de conexão ou consulta, você pode lidar com isso aqui
        echo "Erro: " . $e->getMessage();
    }
} else {
    header("Location: /index.php");
    exit();
}
