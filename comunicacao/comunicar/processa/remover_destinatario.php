<?php
session_start();

if ($_SESSION['id']) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";
        $comDest = $_POST['comDest'];

        try {
            // Prepare a consulta SQL para atualizar a coluna 'active' para 0
            $stmt = $pdo->prepare("UPDATE comunicacao_destinatarios SET active = 0 WHERE id = :comDest");
            $stmt->bindParam(':comDest', $comDest, PDO::PARAM_INT);

            // Execute a consulta
            $stmt->execute();

            // Redirecione de volta para a página anterior ou faça qualquer outra ação necessária
            header("Location: /comunicacao/comunicar/index.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro na atualização: " . $e->getMessage();
        }
    }
}
