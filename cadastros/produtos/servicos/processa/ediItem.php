<?php
require "../../../../conexoes/conexao_pdo.php";


if (empty($_POST['itemID']) || empty($_POST['item']) || empty($_POST['descricaoItemEdit'])) {
    echo "<p style='color:red;'>Dados obrigatórios não preenchidos.</p>";
} else {

    $itemID = $_POST['itemID'];
    $item = $_POST['item'];
    $activeEditar = $_POST['activeEditar'];

    if (empty($_POST['codIntEdit'])) {
        $codIntEdit = "";
    } else {
        $codIntEdit = $_POST['codIntEdit'];
    };

    $descricaoItemEdit = $_POST['descricaoItemEdit'];

    $cont_insert = false;

    $data = [
        'itemID' => $itemID,
        'item' => $item,
        'activeEditar' => $activeEditar,
        'codIntEdit' => $codIntEdit,
        'descricaoItemEdit' => $descricaoItemEdit,
    ];
    $sql = "UPDATE iten_service SET item=:item, integration_code=:codIntEdit, description=:descricaoItemEdit, active=:activeEditar WHERE id=:itemID";
    $stmt = $pdo->prepare($sql);

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
}
