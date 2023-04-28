<?php
require "../../../../conexoes/conexao_pdo.php";

$idAtributo = $_POST['idAtributo'];

$data = [
    'idAtributo' => $idAtributo,
];
$sql = "UPDATE equipamentos_atributos SET active='0' WHERE id=:idAtributo";
$stmt= $pdo->prepare($sql);
$stmt->execute($data);