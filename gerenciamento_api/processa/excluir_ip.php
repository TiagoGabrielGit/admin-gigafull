<?php
session_start();

if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    require "../../conexoes/conexao_pdo.php";
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $ip_id = $_GET['id'];

        // Consulta SQL para excluir o IP com base no ID
        $sql = "DELETE FROM api_externa_ip WHERE id = :ip_id";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':ip_id', $ip_id, PDO::PARAM_INT);
            $stmt->execute();

            echo "<script>window.history.back();</script>";
            exit;
        } catch (PDOException $e) {
            echo "Erro ao excluir IP: " . $e->getMessage();
        }
    } else {
        echo "ID de IP inválido.";
    }

    // Feche a conexão com o banco de dados
    $pdo = null;
}
