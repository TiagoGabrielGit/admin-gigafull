<?php
require "../../../../conexoes/conexao_pdo.php";

$classificacaoID = $_POST['classificacaoID'];
$classificacaoIncidenteEditar = $_POST['classificacaoIncidenteEditar'];
$descricaoClassificacaoEditar = $_POST['descricaoClassificacaoEditar'];
$ativoClassificacaoEditar = $_POST['ativoClassificacaoEditar'];

$data = [
    'classificacaoID' => $classificacaoID,
    'classificacaoIncidenteEditar' => $classificacaoIncidenteEditar,
    'descricaoClassificacaoEditar' => $descricaoClassificacaoEditar,
    'active' => $ativoClassificacaoEditar,
];

$sql2 = "UPDATE incidentes_classificacao SET classificacao=:classificacaoIncidenteEditar, descricao=:descricaoClassificacaoEditar, active=:active WHERE id=:classificacaoID";
$stmt2 = $pdo->prepare($sql2);


if ($stmt2->execute($data)) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}

if ($cont_insert) {
    echo "<p style='color:green;'>Classificação editada com sucesso!</p>";
} else {
    echo "<p style='color:red;'>Erro ao editar classificação</p>";
}