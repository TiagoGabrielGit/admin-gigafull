<?php
session_start();
if (isset($_SESSION['id'])) {
    require "../../../conexoes/conexao_pdo.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recuperar os dados do formulário
        // Recuperar os dados do formulário
        $pedidoID = $_POST['pedido_id'];
        $produtoID = $_POST["produto"];
        $quantidade = $_POST["quantidade"];
        $preco_custo_str = $_POST['preco_custo'];
        $valor_unitario_str = $_POST['valor_unitario'];

        // Substituir a vírgula por ponto e remover caracteres não numéricos
        $valor_unitario_str = str_replace(',', '.', preg_replace('/[^\d,]/', '', $valor_unitario_str));
        $preco_custo_str = str_replace(',', '.', preg_replace('/[^\d,]/', '', $preco_custo_str));

        // Converter para float
        $valor_unitario = floatval($valor_unitario_str);
        $preco_custo = floatval($preco_custo_str);
        $total_custo = ($preco_custo * $quantidade);
        $subtotal = ($valor_unitario * $quantidade);
        $lucro_produto = ($subtotal - $total_custo);
        // Verificar se o produto e a quantidade foram selecionados
        if ($produtoID && $quantidade > 0) {
            // Inserir o produto no pedido
            $sql_inserir_produto = "INSERT INTO ecommerce_pedido_produto (pedido_id, lucro_produto, preco_custo, custo_total, produto_id, quantidade, valor_unitario, subtotal) VALUES (:pedido_id, :lucro_produto, :preco_custo, :custo_total, :produto_id, :quantidade, :valor_unitario, :subtotal)";
            $stmt_inserir_produto = $pdo->prepare($sql_inserir_produto);
            $stmt_inserir_produto->bindParam(":pedido_id", $pedidoID);
            $stmt_inserir_produto->bindParam(":produto_id", $produtoID);
            $stmt_inserir_produto->bindParam(":quantidade", $quantidade);
            $stmt_inserir_produto->bindParam(":preco_custo", $preco_custo);
            $stmt_inserir_produto->bindParam(":custo_total", $total_custo);
            $stmt_inserir_produto->bindParam(":lucro_produto", $lucro_produto);

            $stmt_inserir_produto->bindParam(":valor_unitario", $valor_unitario);
            $stmt_inserir_produto->bindParam(":subtotal", $subtotal);
            if ($stmt_inserir_produto->execute()) {
                // Redirecionar de volta para a página de dados do pedido
                header("Location: /ecommerce/venda/pedido.php?pedido_id=$pedidoID");
                exit();
            } else {
                echo "Erro ao inserir produto no pedido no banco de dados.";
            }
        } else {
            echo "Por favor, selecione um produto e forneça uma quantidade válida.";
        }
    } else {
        // Se não for uma requisição POST, redirecionar para a página de dados do pedido
        header("Location: /ecommerce/venda/pedido.php?pedido_id=$pedidoID");
        exit();
    }
}
