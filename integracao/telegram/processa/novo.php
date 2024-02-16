<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once("../../../conexoes/conexao_pdo.php");

    // Verifique se as variáveis POST estão definidas
    if (isset($_POST['tokenTelegram']) && isset($_POST['descricaoToken'])) {

        // Pegue os valores dos campos do formulário
        $tokenTelegram = $_POST['tokenTelegram'];
        $descricaoToken = $_POST['descricaoToken'];

        // Preparar a declaração SQL de inserção
        $sql = "INSERT INTO integracao_telegram (token, descricao, active) VALUES (:token, :descricao, 1)";

        // Preparar e executar a declaração
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':token', $tokenTelegram);
        $stmt->bindParam(':descricao', $descricaoToken);

        // Executar a declaração
        if ($stmt->execute()) {
            header("Location: /integracao/telegram/index.php");
            exit();
        } else {
            echo "Erro ao executar a declaração de inserção.";
        }
    } else {
        echo "Token Telegram e Descrição do Token são obrigatórios.";
    }
} else {
    header("Location: /index.php");
    exit();
}
