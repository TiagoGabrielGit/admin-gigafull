<?php
session_start();
if (isset($_SESSION['id'])) {
    require "../../../conexoes/conexao_pdo.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar os dados do formulário
        $clienteID = $_POST["cliente"];

        // Verificar se o cliente foi selecionado
        if ($clienteID) {
            // Insira o pedido na tabela ecommerce_pedido
            $sql_inserir_pedido = "INSERT INTO ecommerce_pedido (cliente_id, date, status, archived) VALUES (:cliente_id, NOW(), 0, 0)";
            $stmt_inserir_pedido = $pdo->prepare($sql_inserir_pedido);
            $stmt_inserir_pedido->bindParam(":cliente_id", $clienteID);

            if ($stmt_inserir_pedido->execute()) {
                // Obtenha o ID do pedido recém-inserido
                $pedidoID = $pdo->lastInsertId();

                // Redirecione para a página onde você adicionará os produtos ao pedido
                header("Location: ../pedido.php?pedido_id=$pedidoID");
                exit();
            } else {
                echo "Erro ao inserir pedido no banco de dados.";
            }
        } else {
            echo "Por favor, selecione um cliente.";
        }
    }
} else {
    // Se o usuário não estiver autenticado, redirecione para a página de login ou tome outra ação apropriada
    header("Location: /index.php");
    exit();
}
