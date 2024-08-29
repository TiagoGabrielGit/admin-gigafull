<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    try {

        $dashboard = $_POST['dashboard'];
        $url = $_POST['url'];
        $active = 1; // Definindo o valor padrão para active

        // Gerando um token aleatório
        $token = bin2hex(random_bytes(16));

        // Preparar a consulta SQL de inserção
        $stmt = $pdo->prepare("INSERT INTO metabase (dashboard, url, active, token) VALUES (:dashboard, :url, :active, :token)");

        // Vincular os parâmetros com os valores capturados do formulário
        $stmt->bindParam(':dashboard', $dashboard);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':token', $token);

        // Executar a consulta
        $stmt->execute();

        header("Location: /relatorios/metabase/index.php");
        exit();
    } catch (PDOException $e) {
        // Exibir mensagem de erro em caso de falha na conexão ou inserção
        echo "Erro: " . $e->getMessage();
    }

    // Fechar a conexão (opcional, pois o PDO fecha automaticamente ao final do script)
    $pdo = null;
} else {
    header("Location: /index.php");
    exit();
}
