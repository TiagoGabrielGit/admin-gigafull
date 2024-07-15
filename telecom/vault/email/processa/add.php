<?php
session_start();

if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
        $usuarioCriador = $_POST['usuarioCriador'];

        //Cabecalho
        $cadastroEmpresa = $_POST['cadastroEmpresa'];
        $cadastroTipo = "email";
        $cadastroPrivacidade = $_POST['cadastroPrivacidade'];

        //tipo = email
        $acessoWebmail = $_POST['acessoWebmail'];
        $emailDescricao = $_POST['emailDescricao'];
        $emailUsuario = $_POST['emailUsuario'];
        $emailSenha = $_POST['emailSenha'];
        $emailAnotacao = $_POST['emailAnotacao'];

        $cont_insert = false;

        $sql = "INSERT INTO credenciais_email (empresa_id, tipo, usuario_id, privacidade, webmail, emaildescricao, emailusuario, emailsenha, anotacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$cadastroEmpresa, $cadastroTipo, $usuarioCriador, $cadastroPrivacidade, $acessoWebmail, $emailDescricao, $emailUsuario, $emailSenha, $emailAnotacao])) {
            $cont_insert = true;
        } else {
            $cont_insert = false;
        }


        if ($cont_insert) {
            header("Location: /telecom/vault/email/index.php");
            exit();
        } else {
            header("Location: /telecom/vault/email/index.php");
            exit();
        }

        if ($cont_insert) {
        } else {
            header("Location: /telecom/vault/email/index.php");
            exit();
        }
    }
}
