<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $agrupamento_id = trim($_POST['agrupamento']);
        $centro_de_custo = trim($_POST['centro_de_custo']);

        try {
            $sql = "INSERT INTO cc_centro_de_custo (agrupamento_id, centro_de_custo, active) VALUES (:agrupamento_id, :centro_de_custo, 1)";
            $stmt = $pdo->prepare($sql);

            // Vincular os valores dos campos aos parâmetros da consulta
            $stmt->bindParam(':agrupamento_id', $agrupamento_id, PDO::PARAM_INT);
            $stmt->bindParam(':centro_de_custo', $centro_de_custo, PDO::PARAM_STR);

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
