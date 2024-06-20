<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
try {
    // Verifica se o formulário foi submetido via POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recupera o valor da nova licença
        $nova_licenca = trim($_POST['nova_licenca']);

        // Verifica se o campo de licença não está vazio
        if (!empty($nova_licenca)) {
            // Prepara a consulta SQL para atualizar a licença
            $sql = "UPDATE licenca SET licenca = :nova_licenca WHERE id = 1";

            // Prepara a execução da consulta
            $stmt = $pdo->prepare($sql);

            // Vincula o parâmetro da nova licença
            $stmt->bindParam(':nova_licenca', $nova_licenca, PDO::PARAM_STR);

            // Executa a consulta
            if ($stmt->execute()) {
                $_SESSION['msg'] = 'Licença atualizada com sucesso!';
            } else {
                $_SESSION['msg'] = 'Erro ao atualizar a licença. Por favor, tente novamente.';
            }
        } else {
            $_SESSION['msg'] = 'O campo de licença não pode estar vazio!';
        }
    }
} catch (PDOException $e) {
    // Define uma mensagem de erro com detalhes da exceção
    $_SESSION['msg'] = 'Erro ao conectar ao banco de dados: ' . htmlspecialchars($e->getMessage());
}
header('Location: /index.php'); // Modifique este caminho para a página adequada
exit;
