<?php
session_start();

if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    require "../../conexoes/conexao_pdo.php";

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        // Consulta SQL para atualizar o valor da coluna "active" para 0
        $sql = "UPDATE api SET active = 1 WHERE id = :id";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Após a atualização, redirecione o usuário para alguma página
            echo "<script>window.history.back();</script>";
            exit;
        } catch (PDOException $e) {
            echo "Erro ao atualizar o registro: " . $e->getMessage();
        }
    } else {
        echo "ID de incidente inválido.";
    }

    // Feche a conexão com o banco de dados
    $pdo = null;
}
