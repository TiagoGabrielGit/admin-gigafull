<?php
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
    exit();
}
// Verificar se o ID foi fornecido
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitizar o ID para evitar SQL Injection

    // Preparar a instrução SQL para exclusão
    $sql = "DELETE FROM cc_orcamentos WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);

        // Bind do parâmetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Executar a instrução
        if ($stmt->execute()) {
            // Redirecionar de volta com uma mensagem de sucesso
            header("Location: /financeiro/orcamento/orcamentos/index.php");
            exit();
        } else {
            // Redirecionar de volta com uma mensagem de erro
            header("Location: /financeiro/orcamento/orcamentos/index.php");
            exit();
        }
    } catch (PDOException $e) {
        // Em caso de erro, redirecionar com mensagem de erro
        header("Location: /financeiro/orcamento/orcamentos/index.php");
        exit();
    }
} else {
    // Redirecionar de volta com mensagem de erro se o ID não for fornecido
    header("Location: /financeiro/orcamento/orcamentos/index.php");
    exit();
}
