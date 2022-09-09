<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$idCadastroCredencialUsuario = $_GET["idCadastroCredencialUsuario"];

$dados = [
    'idCadastroCredencialUsuario' => $idCadastroCredencialUsuario
];

$sql = "DELETE FROM credenciais_privacidade_usuario WHERE id = :idCadastroCredencialUsuario";

$stmt= $pdo->prepare($sql);
$stmt->execute($dados); 