<?php
//session_start();
require "../../../../conexoes/conexao_pdo.php";
//include_once '../../../conexoes/conexao_pdo.php';

//Informacoes gerais
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
    echo "<p style='color:green;'>Cadastrado com Sucesso</p>";
} else {
    echo "<p style='color:red;'>Erro ao cadastrar</p>";
}

if ($cont_insert) {
} else {
    echo "<p style='color:red;'>Erro ao cadastrar</p>";
}
