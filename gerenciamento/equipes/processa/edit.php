<?php
require "../../../conexoes/conexao_pdo.php";
$idEquipe = $_POST['idEquipe'];
$editEquipe = $_POST['editEquipe'];
$active = $_POST['editStatus'];

$dados = [
    'idEquipe' => $idEquipe,
    'editEquipe' => $editEquipe,
    'active' => $active,
];

$sql_update = "UPDATE equipe SET equipe=:editEquipe, active=:active WHERE id=:idEquipe";

$stmt= $pdo->prepare($sql_update);
$stmt->execute($dados);