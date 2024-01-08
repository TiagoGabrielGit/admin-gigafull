<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
require "../../../conexoes/conexao_pdo.php";

$submenu_id = "45";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT 
    u.perfil_id
FROM 
    usuarios u
JOIN 
    perfil_permissoes_submenu pp
ON 
    u.perfil_id = pp.perfil_id
WHERE
    u.id = :uid
AND 
    pp.url_submenu = :submenu_id";

try {
    $exec_permissions_menu = $pdo->prepare($permissions_menu);
    $exec_permissions_menu->bindParam(':uid', $uid, PDO::PARAM_INT);
    $exec_permissions_menu->bindParam(':submenu_id', $submenu_id, PDO::PARAM_INT);
    $exec_permissions_menu->execute();

    $rowCount_permissions_menu = $exec_permissions_menu->rowCount();

    if ($rowCount_permissions_menu > 0) {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $produto_id = $_POST['produto_id'];
            $fornecedor_id = $_POST['fornecedor'];
            $custo = $_POST['custo'];
            $codigo_fornecedor = isset($_POST['codigo_fornecedor']) ? $_POST['codigo_fornecedor'] : null;

            try {
                // Insira os dados na tabela produtos_ecommerce_custos
                $sql_inserir_custo = "INSERT INTO ecommerce_produtos_custos (produto_id, fornecedor_id, custo, atualizado, cod_produto) VALUES (:produto_id, :fornecedor_id, :custo, NOW(), :cod_produto)";
                $stmt_inserir_custo = $pdo->prepare($sql_inserir_custo);
                $stmt_inserir_custo->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                $stmt_inserir_custo->bindParam(':fornecedor_id', $fornecedor_id, PDO::PARAM_INT);
                $stmt_inserir_custo->bindParam(':custo', $custo, PDO::PARAM_STR);
      // Verifica se o código do produto não está vazio antes de vinculá-lo
      if ($codigo_fornecedor !== null) {
        $stmt_inserir_custo->bindParam(':cod_produto', $codigo_fornecedor, PDO::PARAM_STR);
    } else {
        $stmt_inserir_custo->bindValue(':cod_produto', null, PDO::PARAM_NULL);
    }


                $stmt_inserir_custo->execute();

                // Redireciona de volta à página anterior ou para onde desejar após a inserção bem-sucedida
                header("Location: /ecommerce/produtos_ecommerce/view_produtos.php?id=$produto_id");
                exit();
            } catch (PDOException $e) {
                echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
            }
        } else {
            header("Location: /ecommerce/produtos_ecommerce/view_produtos.php?id=$produto_id");
            exit();
        }
    } else {
        // Usuário não tem permissão para acessar esta página, redirecione ou trate conforme necessário
        header("Location: acesso_negado.php");
        exit();
    }
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
} finally {
    // Inclua aqui qualquer código que precisa ser executado independentemente das condições anteriores
    // Por exemplo, incluir o rodapé ou realizar ações de limpeza
}
