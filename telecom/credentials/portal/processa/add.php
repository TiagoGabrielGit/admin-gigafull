<?php
//session_start();
require "../../../../conexoes/conexao_pdo.php";
//include_once '../../../conexoes/conexao_pdo.php';

//Informacoes gerais
$usuarioCriador = $_POST['usuarioCriador'];

//Cabecalho
$cadastroEmpresa = $_POST['cadastroEmpresa'];
$cadastroTipo = "portal";
$cadastroPrivacidade = $_POST['cadastroPrivacidade'];

//tipo = portal
$portalPaginaAcesso = $_POST['portalPaginaAcesso'];
$portalDescricao = $_POST['portalDescricao'];
$portalUsuario = $_POST['portalUsuario'];
$portalSenha = $_POST['portalSenha'];
$portalAnotacao = $_POST['portalAnotacao'];


$cont_insert = false;


$sql = "INSERT INTO credenciais_portal (empresa_id, tipo, usuario_id, privacidade, paginaacesso, portaldescricao, portalusuario, portalsenha, anotacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$cadastroEmpresa, $cadastroTipo, $usuarioCriador, $cadastroPrivacidade, $portalPaginaAcesso, $portalDescricao, $portalUsuario, $portalSenha, $portalAnotacao])) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}


if ($cont_insert) {
    $lastInsertedId = $pdo->lastInsertId();
    header("Location: /telecom/credentials/portal/view.php?id=$lastInsertedId&tipo=Portal");
    exit();
} else {
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
    exit();
}