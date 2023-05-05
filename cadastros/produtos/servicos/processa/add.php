<?php
require "../../../../conexoes/conexao_pdo.php";

$descricao = $_POST['descricao'];
$servico = $_POST['servico'];
$item_service = $_POST['item_service'];
$active = "1";
$cont_insert = false;

$sql_insert_servico = "INSERT INTO service (service, description, item_service, active) VALUES (:service, :description, :item_service, :active)";
$stmt1 = $pdo->prepare($sql_insert_servico);
$stmt1->bindParam(':description', $descricao);
$stmt1->bindParam(':service', $servico);
$stmt1->bindParam(':item_service', $item_service);
$stmt1->bindParam(':active', $active);

if ($stmt1->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}

if ($cont_insert) {
    echo "<p style='color:green;'>Cadastrado com Sucesso</p>";
} else {
    echo "<p style='color:red;'>Erro ao cadastrar</p>";
}
