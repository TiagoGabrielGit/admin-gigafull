<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

/////////////////////////////////////////

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$query_perfil = "INSERT INTO redeneutra_profile_parceiro (perfil, redeneutra_parceiro_id, redeneutra_olt_id, line_profile_id, srv_profile_id, active)
VALUES (:perfil, :redeneutra_parceiro_id, :redeneutra_olt_id, :line_profile_id, :srv_profile_id, '1')";
$stmt = $pdo->prepare($query_perfil);
$stmt->bindParam(':perfil', $dados['perfil']);
$stmt->bindParam(':redeneutra_parceiro_id', $dados['parceiro']);
$stmt->bindParam(':redeneutra_olt_id', $dados['idOLT']);
$stmt->bindParam(':line_profile_id', $dados['lineProfile']);
$stmt->bindParam(':srv_profile_id', $dados['srvProfile']);
$stmt->execute();

if ($stmt->rowCount()) {
    $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Perfil cadastrado com sucesso!</div>"];
} else {
    $retorna = $dados;
    //$retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso!</div>"];
}

echo json_encode($retorna);
