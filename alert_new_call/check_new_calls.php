<?php
$horario_ultima_consulta = "";
$valor_chamados = "";
$horario_atual = date('Y-m-d H:i:s');

if ($horario_ultima_consulta === NULL) {
    $horario_ultima_consulta = date('Y-m-d H:i:s', strtotime('2000-05-10 19:30:45'));
}

// Convertendo as datas para timestamps
$timestamp_ultima_consulta = strtotime($horario_ultima_consulta);
$timestamp_atual = strtotime($horario_atual);

// Verificando se a diferença é de pelo menos 60 segundos
if ($timestamp_atual - $timestamp_ultima_consulta >= 60) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao.php');
    $sql_chamados_abertos = "SELECT COUNT(*) as total FROM chamados";
    $result_chamados_abertos = $mysqli->query($sql_chamados_abertos);
    $row_chamados_abertos = $result_chamados_abertos->fetch_assoc();
    $valor_chamados = $row_chamados_abertos["total"];

    echo "teste 1 <br>";
    echo $valor_chamados;
    $horario_ultima_consulta = $horario_atual;
} else {
    echo "teste 2 <br>";
    echo $valor_chamados;
}
