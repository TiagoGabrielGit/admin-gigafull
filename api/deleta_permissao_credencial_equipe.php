<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$idCadastroCredencialEquipe = $_GET["idCadastroCredencialEquipe"];

$dados = [
    'idCadastroCredencialEquipe' => $idCadastroCredencialEquipe
];

$sql = "DELETE FROM credenciais_privacidade_equipe WHERE id = :idCadastroCredencialEquipe";

$stmt= $pdo->prepare($sql);
$stmt->execute($dados);