<?php
session_start();
include_once '../../../conexoes/conexao_pdo.php';

//Informacoes gerais
$usuarioCriador = $_POST['usuarioCriador'];

//Cabecalho
$cadastroEmpresa = $_POST['cadastroEmpresa'];
$cadastroTipo = $_POST['cadastroTipo'];
$cadastroPrivacidade = $_POST['cadastroPrivacidade'];

//tipo = portal
$portalPaginaAcesso = $_POST['portalPaginaAcesso'];
$portalDescricao = $_POST['portalDescricao'];
$portalUsuario = $_POST['portalUsuario'];
$portalSenha = $_POST['portalSenha'];
$portalAnotacao = $_POST['portalAnotacao'];

//tipo = email
$acessoWebmail = $_POST['acessoWebmail'];
$emailDescricao = $_POST['emailDescricao'];
$emailUsuario = $_POST['emailUsuario'];
$emailSenha = $_POST['emailSenha'];
$emailAnotacao = $_POST['emailAnotacao'];

$cont_insert = false;

if ($cadastroTipo == "portal") {

    $sql = "INSERT INTO credenciais_portal (empresa_id, tipo, usuario_id, privacidade, paginaacesso, portaldescricao, portalusuario, portalsenha, anotacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$cadastroEmpresa, $cadastroTipo, $usuarioCriador, $cadastroPrivacidade, $portalPaginaAcesso, $portalDescricao, $portalUsuario, $portalSenha, $portalAnotacao])) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    
    if ($cont_insert) {
        echo "<p style='color:green;'>Cadastrado com Sucesso</p>";
    } else {
        echo "<p style='color:red;'>Erro ao cadastrar</p>";
    }
}


if ($cadastroTipo == "email") {

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
}


if ($cont_insert) {
} else {
    echo "<p style='color:red;'>Erro ao cadastrar</p>";
}
