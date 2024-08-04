<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $categoria = trim($_POST['categoria']);

        try {
            $sql = "INSERT INTO cc_categoria (categoria, active) VALUES (:categoria, 1)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);

            // Executar a consulta
            if ($stmt->execute()) {
                header("Location: ../index.php?msg=success");
                exit;
            } else {
                header("Location: ../index.php?msg=error");
                exit;
            }
        } catch (PDOException $e) {
            // Tratar erros de execução da consulta
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header("Location: ../index.php");
        exit;
    }
} else {
    header("Location: /index.php");
    exit();
}
