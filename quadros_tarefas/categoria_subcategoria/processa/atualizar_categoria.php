<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Verificando se o usuário está logado
if (isset($_SESSION['id'])) {
    // Obtendo os dados do formulário
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validação básica dos dados enviados
        $id_categoria = isset($_POST['id_categoria']) ? (int)$_POST['id_categoria'] : 0;
        $descricao = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
        $status = isset($_POST['status']) ? (int)$_POST['status'] : 1; // Default: ativo

        if ($id_categoria > 0 && !empty($descricao)) {
            try {
                // Atualizando a categoria no banco de dados
                $update_query = "UPDATE qt_categorias SET descricao = :descricao, active = :status WHERE id = :id";
                $update_stmt = $pdo->prepare($update_query);
                $update_stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
                $update_stmt->bindValue(':status', $status, PDO::PARAM_INT);
                $update_stmt->bindValue(':id', $id_categoria, PDO::PARAM_INT);

                if ($update_stmt->execute()) {
                    $_SESSION['msg'] = "Atualizado com sucesso";

                    header("Location: /quadros_tarefas/categoria_subcategoria/view_categoria.php?id=$id_categoria");
                    exit();
                } else {
                    $_SESSION['msg'] = "Erro ao atualizar";
                    header("Location: /quadros_tarefas/categoria_subcategoria/view_categoria.php?id=$id_categoria");
                    exit();
                }
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        } else {
            header("Location: /quadros_tarefas/categoria_subcategoria/view_categoria.php?id=$id_categoria");
            exit();
        }
    } else {
        echo "Requisição inválida.";
    }
} else {
    // Se o usuário não está logado, redireciona para a página de login
    header("Location: /index.php");
    exit();
}
