<?php
require "../../conexoes/conexao_pdo.php";

$contractIDInformation = $_POST['contractIDInformation'];
$statusContrato = $_POST['statusContrato'];

$data = [
    'contractIDInformation' => $contractIDInformation,
    'statusContrato' => $statusContrato,
];

$sql2 = "UPDATE contract SET active=:statusContrato WHERE id=:contractIDInformation";
$stmt2 = $pdo->prepare($sql2);


if ($stmt2->execute($data)) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}

if ($cont_insert) {
    echo "<p style='color:green;'>Contrato editado com sucesso!  
    </p>";
} else {
    echo "<p style='color:red;'>Erro ao editar contrato</p>";
}