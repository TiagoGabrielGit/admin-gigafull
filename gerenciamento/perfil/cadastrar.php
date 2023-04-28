<?php
include_once "../../conexoes/conexao_pdo.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['nomePerfil'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>"];
} else {
    $query_perfil = "INSERT INTO perfil (perfil, active) VALUES (:perfil, '1')";
    $stmt = $pdo->prepare($query_perfil);
    $stmt->bindParam(':perfil', $dados['nomePerfil']);
    $stmt->execute();

    if ($stmt->rowCount()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso!</div>"];
    } else {
        $retorna = $dados;
        //$retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso!</div>"];
    }
}

echo json_encode($retorna);
