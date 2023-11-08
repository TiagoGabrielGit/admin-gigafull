<?php
session_start();

if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = $_POST['ip'];
    $descricao = $_POST['descricao'];
    $id = $_POST['id'];
    require "../../conexoes/conexao_pdo.php";

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar a declaração SQL para inserção
        $sql = "INSERT INTO api_externa_ip (api_id, ip, descricao) VALUES (:api_id, :ip, :descricao)";
        $stmt = $pdo->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':api_id', $id);
        $stmt->bindParam(':ip', $ip);
        $stmt->bindParam(':descricao', $descricao);

        // Executar a declaração SQL
        if ($stmt->execute()) {
            header("Location: /gerenciamento_api/view.php?id=$id");
            exit;
        } else {
            header("Location: /gerenciamento_api/view.php?id=$id");
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro ao inserir dados: " . $e->getMessage();
    }

    $pdo = null;
} else {
    header("Location: /gerenciamento_api/view.php?id=$id");
    exit;
}
