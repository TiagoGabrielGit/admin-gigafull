<?php
require "../../conexoes/conexao_pdo.php";

$idCadastro = $_POST['idCadastro2'];

$dados = [
    'idCadastro' => $idCadastro,
];

$sql_delete = "DELETE FROM chamados_autorizados_by_company WHERE id = :idCadastro";

$stmt= $pdo->prepare($sql_delete);
$stmt->execute($dados);