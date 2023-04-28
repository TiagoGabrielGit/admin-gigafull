<?php
require "../../../conexoes/conexao_pdo.php";


$nomenclatura = $_POST['nomenclaturaRack'];
$tamanho = $_POST['tamanhoRack'];
$polegada = $_POST['polegadaRack'];
$id = $_POST['idRack'];

$cont_insert = false;


$sql = "UPDATE pop_rack SET nomenclatura = :nomenclatura, tamanho = :tamanho, polegada = :polegada  WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nomenclatura', $nomenclatura);
$stmt->bindParam(':tamanho', $tamanho);
$stmt->bindParam(':polegada', $polegada);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}


if ($cont_insert) {
    echo "<p style='color:green;'>Editado com Sucesso</p>";
} else {
    echo "<p style='color:red;'>Erro ao editar</p>";
}
