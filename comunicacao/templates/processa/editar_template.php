<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";
        
        try {
            // Recupere os dados do formulário
            $id = $_POST["id"]; // Certifique-se de ter um campo 'id' no formulário
            $title = $_POST["title"];
            $tipo = $_POST["tipo"];
            $aplicado = $_POST["aplicado"];
            $conteudo = $_POST["conteudo"]; // Você precisa ajustar isso para corresponder ao campo de texto do editor

            // Atualize os dados no banco de dados
            $sql_update = "UPDATE comunicacao_templates 
                           SET titulo = :title, tipo = :tipo, aplicado = :aplicado, template = :conteudo
                           WHERE id = :id";

            $stmt = $pdo->prepare($sql_update);

            // Associe os valores do formulário aos parâmetros da consulta
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':aplicado', $aplicado);
            $stmt->bindParam(':conteudo', $conteudo);
            $stmt->bindParam(':id', $id);

            // Execute a consulta de atualização
            $stmt->execute();

            // Redirecione para uma página de sucesso ou faça qualquer outra coisa que você queira após a atualização bem-sucedida
            header("Location: /comunicacao/templates/view.php?id=$id");
            exit();
        } catch (PDOException $e) {
            // Em caso de erro, você pode lidar com isso de várias maneiras, como registrar o erro ou redirecionar para uma página de erro
            echo "Erro: " . $e->getMessage();
        }
    }
}
