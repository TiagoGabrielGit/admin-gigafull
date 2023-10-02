<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../../../conexoes/conexao_pdo.php";

    try {
        // Obtenha os valores do formulário
        $id = $_POST['id'];
        $editPrivacidade = $_POST['editPrivacidade'];
        $editDescricao = $_POST['editDescricao'];
        $editUsuario = $_POST['editUsuario'];
        $editSenha = $_POST['editSenha'];

        // Atualize os dados na tabela credenciais_equipamento
        $sql = "UPDATE credenciais_equipamento 
                    SET privacidade = :privacidade, equipamentodescricao = :descricao, equipamentousuario = :usuario, equipamentosenha = :senha 
                    WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':privacidade', $editPrivacidade, PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $editDescricao, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $editUsuario, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $editSenha, PDO::PARAM_STR);

        $stmt->execute();

        // Redirecione para a página de visualização
        header("Location: /telecom/credentials/equipamentos/credenciais/view.php?id=$id");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar os dados: " . $e->getMessage();
    }
}
