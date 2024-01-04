<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require "../../../conexoes/conexao_pdo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $custo_id = $_POST['custo_id'];
    $produto_id = $_POST['produto_id'];


    try {
        // Verifique se o usuário tem permissão para excluir o custo (adicione a lógica necessária)
        // Substitua a seguinte linha pelo código real de verificação de permissão
        $podeExcluir = true;

        if ($podeExcluir) {
            // Execute a exclusão do custo
            $sql_excluir_custo = "DELETE FROM ecommerce_produtos_custos WHERE id = :custo_id";
            $stmt_excluir_custo = $pdo->prepare($sql_excluir_custo);
            $stmt_excluir_custo->bindParam(':custo_id', $custo_id, PDO::PARAM_INT);
            $stmt_excluir_custo->execute();

            // Redirecione para a página anterior ou para onde desejar após a exclusão bem-sucedida
            header("Location: /ecommerce/produtos_ecommerce/view_produtos.php?id=$produto_id");
            exit();
        } else {
            // Usuário não tem permissão para excluir o custo, redirecione ou trate conforme necessário
            header("Location: acesso_negado.php");
            exit();
        }
    } catch (PDOException $e) {
        echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    }
} else {
    // Se o formulário não foi enviado, redirecione para a página inicial ou onde desejar
    header("Location: /ecommerce/produtos_ecommerce/view_produtos.php?id=$produto_id");
    exit();
}
