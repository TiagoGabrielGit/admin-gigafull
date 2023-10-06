<?php
session_start();

if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip = $_POST['ip'];
    $descricao = $_POST['descricao'];
    $id = $_POST['id'];
    require "../../../../conexoes/conexao_pdo.php";

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar a declaração SQL para inserção
        $sql = "INSERT INTO incidentes_iframe_ip_address (incidentes_iframe_id, ip, descricao) VALUES (:incidentes_iframe_id, :ip, :descricao)";
        $stmt = $pdo->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':incidentes_iframe_id', $id);
        $stmt->bindParam(':ip', $ip);
        $stmt->bindParam(':descricao', $descricao);

        // Executar a declaração SQL
        if ($stmt->execute()) {
            header("Location: /servicedesk/incidentes/iframe/edit.php?id=$id");
            exit;
        } else {
            header("Location: /servicedesk/incidentes/iframe/edit.php?id=$id");
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro ao inserir dados: " . $e->getMessage();
    }

    $pdo = null;
} else {
    header("Location: /index.php");
    exit;
}
