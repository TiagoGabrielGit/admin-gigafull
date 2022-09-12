<?php
require "../../../../conexoes/conexao_pdo.php";

$id = $_POST['id'];
$descricao = $_POST['descricao'];
$StatusServico = $_POST['StatusServico'];
$unidadeHidden = $_POST['unidadeHidden'];

if ($unidadeHidden == '1') {
    $pacoteHoras = $_POST['pacoteHoras'];
    $valorHora = $_POST['valorHora'];
    $valorHoraExcedente = $_POST['valorHoraExcedente'];

    $valorHora = str_replace('.', '', $valorHora); // remove o ponto
    $valorHora = str_replace(',', '.', $valorHora); // troca a vírgula por ponto

    $valorHoraExcedente = str_replace('.', '', $valorHoraExcedente); // remove o ponto
    $valorHoraExcedente = str_replace(',', '.', $valorHoraExcedente); // troca a vírgula por ponto
} else {
    $pacoteHoras = "";
    $valorHora = "";
    $valorHoraExcedente = "";
}

$cont_insert = false;
 
$data = [
    'descricao' => $descricao,
    'pacoteHoras' => $pacoteHoras,
    'valorHora' => $valorHora,
    'valorHoraExcedente' => $valorHoraExcedente,
    'active' => $StatusServico,
    'id' => $id,
];
$sql = "UPDATE servicos SET descricao=:descricao, pacoteHoras=:pacoteHoras, valorHora=:valorHora, valorHoraExcedente=:valorHoraExcedente, active=:active WHERE id=:id";
$stmt= $pdo->prepare($sql);

if ($stmt->execute($data)) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}


if ($cont_insert) {
    echo "<p style='color:green;'>Cadastrado com Sucesso</p>";
} else {
    echo "<p style='color:red;'>Erro ao cadastrar</p>";
}