<?php
session_start();

if (isset($_SESSION['id']) && isset($_GET['id'])) {
    // Obtém o ID da despesa a ser inativada
    $despesa_id = $_GET['id'];

    // Incluir arquivo de conexão PDO
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    try {
        // Preparando a instrução SQL para inativar a despesa
        $stmt = $pdo->prepare("UPDATE qt_despesas SET active = 0 WHERE id = :despesa_id");
        $stmt->bindValue(':despesa_id', $despesa_id, PDO::PARAM_INT);

        // Executando a instrução SQL
        if ($stmt->execute()) {
            // Redirecionando de volta para a página de onde veio
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            // Em caso de falha na execução da consulta SQL
            echo "Erro ao inativar a despesa.";
        }
    } catch (PDOException $e) {
        // Tratamento de erros do PDO
        echo "Erro ao inativar a despesa: " . $e->getMessage();
    }
} else {
    // Se não estiver logado ou se o ID da despesa não foi recebido
    header("Location: /index.php");
    exit();
}
