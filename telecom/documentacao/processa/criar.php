<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    if (empty($_POST['titleDocumentation']) || empty($_POST['document_content'])) {
        echo "Dados obrigatórios não preenchidos!";
    } else {
        $title = $_POST['titleDocumentation'];
        $content = $_POST['document_content'];
        $criador = $_POST['idUsuario'];

        try {
            $stmt = $pdo->prepare("INSERT INTO documentation (title, document, criador) VALUES (:title, :content, :criador)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':criador', $criador);
            $stmt->execute();

            $lastInsertedId = $pdo->lastInsertId();
            echo $lastInsertedId;
            exit();
        } catch (PDOException $e) {
            echo "Erro ao salvar os dados: " . $e->getMessage();
        }
    }
}
