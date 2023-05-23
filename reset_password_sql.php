<?php
require "conexoes/conexao_pdo.php";

if (empty($_POST['email']) || empty($_POST['confirmEmail']) || empty($_POST['senha']) || empty($_POST['confirmPassword'])) {
    echo "Error001: Dados obrigatórios não preenchidos.";
} else {
    if ($_POST['email'] != $_POST['confirmEmail']) {
        echo "Error: E-mail não conincide.";
    } else {
        if ($_POST['senha'] != $_POST['confirmPassword']) {
            echo "Error: Senhas não coincidem.";
        } else {
            //Código para login
            $email = $_POST['email'];
            $senha = md5($_POST['senha']);
            // Declaração SQL com espaços reservados para os parâmetros
            $sql = "UPDATE usuarios AS u
                    LEFT JOIN pessoas AS p ON p.id = u.pessoa_id
                    SET u.reset_password = '0', u.senha = :senha, u.modificado = NOW()
                    WHERE p.email = :email";

            // Preparação da declaração
            $stmt = $pdo->prepare($sql);

            // Atribuição dos valores aos parâmetros
            $stmt->bindParam(":senha", $senha);
            $stmt->bindParam(":email", $email);

            if ($stmt->execute()) {
                echo "Success";
            }
        }
    }
}
