<?php
require "../../../../conexoes/conexao_pdo.php";

$id = $_POST['serviceID'];
$service = $_POST['servicoEditar'];
$active = $_POST['activeEditar'];
$itemEdit = $_POST['itemEdit'];
$description = $_POST['descricaoEditar'];

$cont_insert = false;
 
$data = [
    'descricao' => $description,
    'servico' => $service,
    'item_service' => $itemEdit,
    'active' => $active,
    'id' => $id,
];
$sql = "UPDATE service SET service=:servico, description=:descricao, item_service=:item_service, active=:active WHERE id=:id";
$stmt= $pdo->prepare($sql);

if ($stmt->execute($data)) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}


if ($cont_insert) {
    echo "<p style='color:green;'>Editado com Sucesso</p>";
} else {
    echo "<p style='color:red;'>Erro ao editar</p>";
} 