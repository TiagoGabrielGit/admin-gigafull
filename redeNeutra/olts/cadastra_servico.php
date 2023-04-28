<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

/////////////////////////////////////////

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_servico = "INSERT INTO redeneutra_profile_service (profile_id, servico, cvlan, svlan, gemport)
VALUES (:profile_id, :servico, :cvlan, :svlan, :gemport)";
$stmt = $pdo->prepare($query_servico);
$stmt->bindParam(':profile_id', $dados['profile_id']);
$stmt->bindParam(':servico', $dados['servico']);
$stmt->bindParam(':cvlan', $dados['cvlan']);
$stmt->bindParam(':svlan', $dados['svlan']);
$stmt->bindParam(':gemport', $dados['gemport']);
$stmt->execute();

if ($stmt->rowCount()) {
    $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Perfil cadastrado com sucesso!</div>"];
} else {
    $retorna = $dados;
    //$retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso!</div>"];
}

echo json_encode($retorna);
