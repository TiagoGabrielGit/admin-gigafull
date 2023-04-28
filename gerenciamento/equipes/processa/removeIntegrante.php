<?php
require "../../../conexoes/conexao_pdo.php";

$idCadastro = $_POST['idCadastro'];

$dados = [
    'idCadastro' => $idCadastro,
];

$sql_delete = "DELETE FROM equipes_integrantes WHERE id = :idCadastro";

$stmt= $pdo->prepare($sql_delete);
$stmt->execute($dados);