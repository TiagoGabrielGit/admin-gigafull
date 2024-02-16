<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
    require "../../../conexoes/conexao_pdo.php";
    try {


        if (isset($_POST['notificacaoAberturaChamado'])) {
            $notificacaoAberturaChamado = $_POST['notificacaoAberturaChamado'];
            $status = $_POST['status'];

            // Preparar e executar a consulta de atualização para notificacaoAberturaChamado
            $stmt = $pdo->prepare("UPDATE notificacao_telegram SET active = :status, token_id = :token_id  WHERE notificacao_id = '1'");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':token_id', $notificacaoAberturaChamado);
            $stmt->execute();
        } else if (isset($_POST['notificacaoRelatoChamado'])) {
            $notificacaoRelatoChamado = $_POST['notificacaoRelatoChamado'];
            $status = $_POST['status'];

            // Preparar e executar a consulta de atualização para notificacaoRelatoChamado
            $stmt = $pdo->prepare("UPDATE notificacao_telegram SET active = :status, token_id = :token_id WHERE notificacao_id = '3'");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':token_id', $notificacaoRelatoChamado);

            $stmt->execute();
        }

        header("Location: /integracao/telegram/index.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    header("Location: /index.php");
    exit();
}
