<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../../../conexoes/conexao_pdo.php"; // Inclua o arquivo de configuração do PDO aqui

    try {
        $idCadastro = $_POST['id'];
        $privacidade = $_POST['editPrivacidade'];
        $descricao = $_POST['editDescricao'];
        $usuario = $_POST['editUsuario'];
        $senha = $_POST['editSenha'];

        $sql = "UPDATE credenciais_vms 
                SET privacidade = :priv, vmdescricao = :descr, vmusuario = :user, vmsenha = :senha 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':priv', $privacidade, PDO::PARAM_INT);
        $stmt->bindParam(':descr', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':user', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':id', $idCadastro, PDO::PARAM_INT);

        $stmt->execute();

        header("Location: /telecom/credentials/vm/credenciais/view.php?id=$idCadastro");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar os dados: " . $e->getMessage();
    }
}
