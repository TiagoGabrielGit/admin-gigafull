<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Dados a serem atualizados
    $urlAPI = filter_input(INPUT_POST, 'urlAPI', FILTER_SANITIZE_URL);
    $chaveAutenticacao = filter_input(INPUT_POST, 'chaveAutenticacao', FILTER_SANITIZE_STRING);
    $id = 1;

    try {
        $sql = "UPDATE integracao_ozmap SET urlAPI = :urlAPI, chaveAutenticacao = :chaveAutenticacao WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Vinculando os parâmetros
        $stmt->bindParam(':urlAPI', $urlAPI);
        $stmt->bindParam(':chaveAutenticacao', $chaveAutenticacao);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        header("Location: /integracao/ozmap/index.php");
        exit();
    } catch (PDOException $e) {
        // Log o erro ou mostre uma mensagem amigável para o usuário
        error_log("Erro ao atualizar o registro: " . $e->getMessage());
        echo "Ocorreu um erro ao atualizar os dados. Por favor, tente novamente mais tarde.";
    }
} else {
    header("Location: /index.php");
    exit();
}
