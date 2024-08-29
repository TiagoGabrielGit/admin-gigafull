<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    try {

        $id = $_POST['id'];
        $dashboard = $_POST['dashboard'];
        $url = $_POST['url'];
        $active = $_POST['active']; // O valor enviado será '1' ou '0'

        // Atualizar os dados do dashboard no banco de dados
        $stmt = $pdo->prepare("UPDATE metabase SET dashboard = :dashboard, url = :url, active = :active WHERE id = :id");

        // Vincular os parâmetros com os valores capturados do formulário
        $stmt->bindParam(':dashboard', $dashboard);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':id', $id);

        // Executar a consulta
        $stmt->execute();

        // Redirecionar ou exibir mensagem de sucesso
        header("Location: /relatorios/metabase/index.php");
        exit();
    } catch (PDOException $e) {
        // Exibir mensagem de erro em caso de falha na conexão ou atualização
        echo "Erro: " . $e->getMessage();
    }

    // Fechar a conexão (opcional, pois o PDO fecha automaticamente ao final do script)
    $pdo = null;
} else {
    header("Location: /index.php");
    exit();
}
