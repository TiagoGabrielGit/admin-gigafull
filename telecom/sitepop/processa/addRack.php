<?php
require "../../../conexoes/conexao_pdo.php";

$pop_id = $_POST['idPOP'];
$nomenclatura = $_POST['nomenclaturaRack'];
$tamanho = $_POST['tamanhoRack'];
$polegada = $_POST['polegadaRack'];

$cont_insert = false;

$sql = "INSERT INTO pop_rack (pop_id, nomenclatura, tamanho, polegada) VALUES (:pop_id, :nomenclatura, :tamanho, :polegada)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pop_id', $pop_id);
$stmt->bindParam(':nomenclatura', $nomenclatura);
$stmt->bindParam(':tamanho', $tamanho);
$stmt->bindParam(':polegada', $polegada);

if ($stmt->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}


if ($cont_insert) {
    echo "<p style='color:green;'>Cadastrado com Sucesso</p>";
} else {
    echo "<p style='color:red;'>Erro ao cadastrar</p>";
}
