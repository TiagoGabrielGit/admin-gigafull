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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['descricaoProduto']) && isset($_POST['lucro']) && isset($_POST['unidade'])) {
                $descricaoProduto = $_POST['descricaoProduto'];
                $lucro = $_POST['lucro'];
                $unidade = $_POST['unidade'];

                // Prepara e executa a inserção no banco de dados
                $sql_inserir_produto = "INSERT INTO ecommerce_produtos (descricao, lucro, unidade, active) VALUES (:descricao, :lucro, :unidade, '1')";
                $stmt_inserir_produto = $pdo->prepare($sql_inserir_produto);
                $stmt_inserir_produto->bindParam(':descricao', $descricaoProduto, PDO::PARAM_STR);
                $stmt_inserir_produto->bindParam(':lucro', $lucro, PDO::PARAM_STR);
                $stmt_inserir_produto->bindParam(':unidade', $unidade, PDO::PARAM_STR);

                // Execute a inserção
                $stmt_inserir_produto->execute();
                $idProduto = $pdo->lastInsertId();

                header("Location: ../view_produtos.php?id=$idProduto");
                exit();
            } else {
                header("Location: ../index.php");
                exit();
            }
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
