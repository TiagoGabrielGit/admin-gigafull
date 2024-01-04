<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require "../../../conexoes/conexao_pdo.php";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $produto_id = $_POST['id'];
    $descricao = $_POST['descricaoProduto'];
    $unidade = $_POST['unidade'];
    $lucro = $_POST['lucro'];
    $fornecedorPrincipal = $_POST['fornecedorPrincipal'];


    try {
        // Inicia uma transação
        $pdo->beginTransaction();

        // Atualiza os dados do produto na tabela produtos_ecommerce
        $sql_atualizar_produto = "UPDATE ecommerce_produtos SET descricao = :descricao, unidade = :unidade, lucro = :lucro WHERE id = :produto_id";
        $stmt_atualizar_produto = $pdo->prepare($sql_atualizar_produto);
        $stmt_atualizar_produto->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt_atualizar_produto->bindParam(':unidade', $unidade, PDO::PARAM_INT);
        $stmt_atualizar_produto->bindParam(':lucro', $lucro, PDO::PARAM_INT);
        $stmt_atualizar_produto->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt_atualizar_produto->execute();

        // Atualiza o custo principal na tabela produtos_ecommerce_custos
        $sql_atualizar_custo_principal = "UPDATE ecommerce_produtos_custos SET principal = 0 WHERE produto_id = :produto_id";
        $stmt_atualizar_custo_principal = $pdo->prepare($sql_atualizar_custo_principal);
        $stmt_atualizar_custo_principal->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt_atualizar_custo_principal->execute();

        $sql_marcar_custo_principal = "UPDATE ecommerce_produtos_custos SET principal = 1 WHERE id = :custo_principal_id";
        $stmt_marcar_custo_principal = $pdo->prepare($sql_marcar_custo_principal);
        $stmt_marcar_custo_principal->bindParam(':custo_principal_id', $fornecedorPrincipal, PDO::PARAM_INT);
        $stmt_marcar_custo_principal->execute();

        // Confirma a transação
        $pdo->commit();

        // Redireciona para a página principal ou outra página após a atualização
        header("Location: /ecommerce/produtos_ecommerce/view_produtos.php?id=$produto_id");
        exit();
    } catch (PDOException $e) {
        // Desfaz a transação em caso de erro
        $pdo->rollBack();
        echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    }
} else {
    // Se não for uma requisição POST, redireciona para uma página apropriada ou exibe uma mensagem de erro
    header("Location: /ecommerce/produtos_ecommerce/view_produtos.php?id=$produto_id");
    exit();
}
