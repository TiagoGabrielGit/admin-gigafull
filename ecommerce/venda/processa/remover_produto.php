<?php
session_start();
if (isset($_SESSION['id'])) {
    
    require "../../../conexoes/conexao_pdo.php";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        if (isset($_GET['produto_id'])) {
            $produtoId = $_GET['produto_id'];

            try {

                $sql_remover_produto = "DELETE FROM ecommerce_pedido_produto WHERE id = :produto_id";
                $stmt_remover_produto = $pdo->prepare($sql_remover_produto);
                $stmt_remover_produto->bindParam(":produto_id", $produtoId);
                $stmt_remover_produto->execute();

                echo "produto: $produtoId";
                // Redirecionar de volta à página de origem
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } catch (PDOException $e) {
                // Lidar com erros de remoção do produto
                echo "Erro ao remover produto: " . $e->getMessage();
            }
        } else {
            echo "doi";
            // Redirecionar caso não haja um produto_id válido
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
