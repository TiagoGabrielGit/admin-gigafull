<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

/////////////////////////////////////////

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$sql_insert_olt =
    "INSERT INTO redeneutra_olts (equipamento_id, olt_name, olt_username, olt_password, active)
VALUES (:equipamento_id, :olt_name, :olt_username, :olt_password, '1')";
$stmt = $pdo->prepare($sql_insert_olt);
$stmt->bindParam(':equipamento_id', $dados['equipamento']);
$stmt->bindParam(':olt_name', $dados['olt']);
$stmt->bindParam(':olt_username', $dados['usuarioOLT']);
$stmt->bindParam(':olt_password', $dados['senhaOLT']);
$stmt->execute();

if ($stmt->rowCount()) {
    $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>OLT cadastrado com sucesso!</div>"];
} else {
    $retorna = $dados;
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: OLT não cadastrado com sucesso!</div>"];
}

echo json_encode($retorna);
