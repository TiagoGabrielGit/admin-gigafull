<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Verificando se o usuário está logado
if (isset($_SESSION['id'])) {
    // Obtendo os dados do formulário
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validação básica dos dados enviados
        $id_subcategoria = isset($_POST['id_subcategoria']) ? (int)$_POST['id_subcategoria'] : 0;
        $descricao = isset($_POST['subcategoria']) ? trim($_POST['subcategoria']) : '';
        $status = isset($_POST['status']) ? (int)$_POST['status'] : 1; // Default: ativo

        // Certifique-se de que o ID da subcategoria e a descrição não estejam vazios
        if ($id_subcategoria > 0 && !empty($descricao)) {
            try {
                // Atualizando a subcategoria no banco de dados
                $update_query = "UPDATE qt_subcategoria SET descricao = :descricao, active = :status WHERE id = :id";
                $update_stmt = $pdo->prepare($update_query);
                $update_stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
                $update_stmt->bindValue(':status', $status, PDO::PARAM_INT);
                $update_stmt->bindValue(':id', $id_subcategoria, PDO::PARAM_INT);

                if ($update_stmt->execute()) {
                    // Redirecionando com sucesso
                    $_SESSION['msg'] = 'Subcategoria atualizada com sucesso!';
                    header("Location: /quadros_tarefas/categoria_subcategoria/view_subcategoria.php?id=$id_subcategoria");
                    exit();
                } else {
                    echo "Erro ao atualizar a subcategoria.";
                }
            } catch (PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        } else {
            echo "Dados inválidos. Por favor, preencha todos os campos corretamente.";
        }
    } else {
        echo "Requisição inválida.";
    }
} else {
    // Se o usuário não está logado, redireciona para a página de login
    header("Location: /index.php");
    exit();
}
