<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $agrupamento = trim($_POST['agrupamento']);

        try {
            $sql = "INSERT INTO cc_agrupamentos (agrupamento, active) VALUES (:agrupamento, 1)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':agrupamento', $agrupamento, PDO::PARAM_STR);

            // Executar a consulta
            if ($stmt->execute()) {
                // Redirecionar para a página de agrupamentos com uma mensagem de sucesso
                header("Location: ../index.php?msg=success");
                exit;
            } else {
                // Redirecionar para a página de agrupamentos com uma mensagem de erro
                header("Location: ../index.php?msg=error");
                exit;
            }
        } catch (PDOException $e) {
            // Tratar erros de execução da consulta
            echo "Erro: " . $e->getMessage();
        }
    } else {
        // Redirecionar para a página de agrupamentos se o método de requisição não for POST
        header("Location: ../index.php");
        exit;
    }
} else {
    header("Location: /index.php");
    exit();
}
