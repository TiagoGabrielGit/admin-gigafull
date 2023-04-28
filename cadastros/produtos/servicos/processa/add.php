<?php
require "../../../../conexoes/conexao_pdo.php";

$Descricao = $_POST['descricao'];
$Servico = $_POST['servico'];
$Unidade = $_POST['Unidade'];
$StatusServico = $_POST['StatusServico'];


if ($Unidade == '1') {
    $PacoteHoras = $_POST['PacoteHoras'];
    $ValorHora = $_POST['ValorHora'];
    $ValorHoraExcedente = $_POST['ValorHoraExcedente'];

    $ValorHora = str_replace('.', '', $ValorHora); // remove o ponto
    $ValorHora = str_replace(',', '.', $ValorHora); // troca a vírgula por ponto

    $ValorHoraExcedente = str_replace('.', '', $ValorHoraExcedente); // remove o ponto
    $ValorHoraExcedente = str_replace(',', '.', $ValorHoraExcedente); // troca a vírgula por ponto
} else {
    $PacoteHoras = "";
    $ValorHora = "";
    $ValorHoraExcedente = "";
}

$cont_insert = false;

$sql_insert_servico = "INSERT INTO servicos 
                            (descricao, unidade, servico, pacoteHoras, valorHora, valorHoraExcedente, active)
                    VALUES (:descricao, :unidade, :servico, :pacoteHoras, :valorHora, :valorHoraExcedente, :active)";
$stmt1 = $pdo->prepare($sql_insert_servico);
$stmt1->bindParam(':descricao', $Descricao);
$stmt1->bindParam(':servico', $Servico);
$stmt1->bindParam(':unidade', $Unidade);
$stmt1->bindParam(':pacoteHoras', $PacoteHoras);
$stmt1->bindParam(':valorHora', $ValorHora);
$stmt1->bindParam(':valorHoraExcedente', $ValorHoraExcedente);
$stmt1->bindParam(':active', $StatusServico);

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
