<?php
require "../../../../conexoes/conexao_pdo.php";

$classificacaoIncidente = $_POST['classificacaoIncidente'];
$descricaoClassificacao = $_POST['descricaoClassificacao'];
$active = "1";

$cont_insert = false;

$sql = "INSERT INTO incidentes_classificacao (classificacao, descricao, active)
        VALUES (:classificacao, :descricao, :active)";
$stmt1 = $pdo->prepare($sql);
$stmt1->bindParam(':classificacao', $classificacaoIncidente);
$stmt1->bindParam(':descricao', $descricaoClassificacao);
$stmt1->bindParam(':active', $active);

if ($stmt1->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}

if ($cont_insert) {
    echo "<p style='color:green;'>Classificação adicionada com sucesso!</p>";
} else {
    echo "<p style='color:red;'>Erro ao adicionar classificação</p>";
}
