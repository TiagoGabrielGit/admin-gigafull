<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    $id = $_POST['id'];
    $privacidade = $_POST['editPrivacidade'];
    $descricao = $_POST['editDescricao'];
    $usuario = $_POST['editUsuario'];
    $senha = $_POST['editSenha'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a instrução SQL para atualizar os dados no banco de dados
        $sql = "UPDATE credenciais_equipamento SET
                    privacidade = :privacidade,
                    equipamentodescricao = :descricao,
                    equipamentousuario = :usuario,
                    equipamentosenha = :senha
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        // Vincule os parâmetros
        $stmt->bindParam(':privacidade', $privacidade, PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute a instrução
        if ($stmt->execute()) {
            // Redirecione para a página de visualização das credenciais
            header("Location: /telecom/vault/equipamentos/editar.php?id={$id}");
            exit;
        } else {
            // Exiba uma mensagem de erro se a atualização falhar
            echo "Erro ao atualizar credencial.";
        }
    } catch (PDOException $e) {
        // Exiba uma mensagem de erro se ocorrer uma exceção
        echo "Erro: " . $e->getMessage();
    }
} else {
    // Redirecione para a página inicial se o acesso não for via POST
    header('Location: /index.php');
    exit;
}
