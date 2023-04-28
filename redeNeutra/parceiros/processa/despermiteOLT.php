<?php
require "../../../conexoes/conexao_pdo.php";

$idPermissao = $_POST['idPermissao'];

$data = [
    'idPermissao' => $idPermissao,
];
$sql = "UPDATE redeneutra_parceiro_olt SET active='0' WHERE id=:idPermissao";
$stmt= $pdo->prepare($sql);
$stmt->execute($data);