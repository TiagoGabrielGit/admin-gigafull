<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_perfil = "INSERT INTO redeneutra_parceiro (codigo, empresa_id, active) VALUES (:codigo, :empresa_id, '1')";
$stmt = $pdo->prepare($query_perfil);
$stmt->bindParam(':codigo', $dados['codigoParceiro']);
$stmt->bindParam(':empresa_id', $dados['parceiro']);
$stmt->execute();

if ($stmt->rowCount()) {
    $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Perfil cadastrado com sucesso!</div>"];
} else {
    $retorna = $dados;
    //$retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso!</div>"];
}

echo json_encode($retorna);
