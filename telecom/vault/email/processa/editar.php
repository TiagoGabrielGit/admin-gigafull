<?php
session_start();

if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        try {
            require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

            $id = $_POST['id'];
            $editPrivacidade = $_POST['editPrivacidade'];
            $editDescricao = $_POST['editDescricao'];
            $editWebmail = $_POST['editWebmail'];
            $editUsuario = $_POST['editUsuario'];
            $editSenha = $_POST['editSenha'];
            $anotacaoEmail = $_POST['anotacaoEmail'];

            $sql = "UPDATE credenciais_email 
                SET privacidade = :privacidade, emaildescricao = :descricao, webmail = :webmail, 
                emailusuario = :usuario, emailsenha = :senha, anotacao = :anotacaoEmail 
                WHERE id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':privacidade', $editPrivacidade, PDO::PARAM_INT);
            $stmt->bindParam(':descricao', $editDescricao, PDO::PARAM_STR);
            $stmt->bindParam(':webmail', $editWebmail, PDO::PARAM_STR);
            $stmt->bindParam(':usuario', $editUsuario, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $editSenha, PDO::PARAM_STR);
            $stmt->bindParam(':anotacaoEmail', $anotacaoEmail, PDO::PARAM_STR);

            $stmt->execute();

            // Redirecione para a página de visualização após a atualização
            header("Location: /telecom/vault/email/view.php?id=$id");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao atualizar os dados: " . $e->getMessage();
        }
    }
}
