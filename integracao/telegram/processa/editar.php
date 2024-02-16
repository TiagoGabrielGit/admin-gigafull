<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
    require_once("../../../conexoes/conexao_pdo.php");

    // Verifica se todos os campos foram enviados
    if (isset($_POST['descricao'], $_POST['token'], $_POST['status'])) {
        $id = $_POST['id'];
        $descricao = $_POST['descricao'];
        $token = $_POST['token'];
        $status = $_POST['status'];

        // Atualiza os dados do token no banco de dados
        $sql = "UPDATE integracao_telegram SET descricao = :descricao, token = :token, active = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        // Executa a declaração
        if ($stmt->execute()) {
            header("Location: /integracao/telegram/index.php");
            exit();
        } else {
            echo "Erro ao atualizar o token.";
        }
    } else {
        echo "Todos os campos são obrigatórios.";
    }
} else {
    header("Location: /index.php");
    exit();
}
