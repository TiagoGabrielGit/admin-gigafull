<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";
        try {
            $title = $_POST["title"];
            $tipo = $_POST["tipo"];
            $aplicado = $_POST["aplicado"];
            $conteudo = $_POST["editorContent"]; // Você precisa ajustar isso para corresponder ao campo de texto do editor Quill

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare a consulta SQL
            $stmt = $pdo->prepare("INSERT INTO comunicacao_templates (titulo, tipo, aplicado, template, `default`, active) VALUES (:title, :tipo, :aplicado, :conteudo, '0', '1')");

            // Associe os valores do formulário aos parâmetros da consulta
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':aplicado', $aplicado);
            $stmt->bindParam(':conteudo', $conteudo);

            // Execute a consulta
            $stmt->execute();
            $ultimoIdInserido = $pdo->lastInsertId();

            // Redirecione para uma página de sucesso ou faça qualquer outra coisa que você queira após a inserção bem-sucedida
            header("Location: /comunicacao/templates/view.php?id=$ultimoIdInserido");
            exit();
        } catch (PDOException $e) {
            echo $_POST["editorContent"];
            echo "Erro PDO: " . $e->getMessage();

            //header("Location: /comunicacao/templates/novo.php");
            //exit();
        }
    }
}
