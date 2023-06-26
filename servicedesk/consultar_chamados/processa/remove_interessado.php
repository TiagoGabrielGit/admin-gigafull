<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    try {
        require "../../../conexoes/conexao_pdo.php";

        // Configuração do modo de erro do PDO para exceções
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_GET['id'];

        // Preparação da consulta SQL
        $stmt = $pdo->prepare("UPDATE chamados_interessados SET active = '0' WHERE id = :id");

        $stmt->bindParam(':id', $id);

        // Execução da consulta preparada
        $stmt->execute();

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } catch (PDOException $e) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Fechamento da conexão
    $pdo = null;
}
