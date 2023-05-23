<?php
require "../../../conexoes/conexao_pdo.php";

$pessoa_id = $_POST['inputNome'];
$user = $_POST['inputEmailHidden'];
$password = $_POST['inputSenha'];
$empresa_id = $_POST['inputEmpresa'];

$cont_insert1 = false;
$cont_insert2 = false;

$sql_portal_user = "INSERT INTO portal_user (pessoa_id, user, password, active) VALUES (:pessoa_id, :user, :password, 1)";
$stmt1 = $pdo->prepare($sql_portal_user);
$stmt1->bindParam(':pessoa_id', $pessoa_id);
$stmt1->bindParam(':user', $user);
$stmt1->bindParam(':password', $password);

if ($stmt1->execute()) {
    $cont_insert1 = true;
    $usuario_id = $pdo->lastInsertId();
} else {
    $cont_insert1 = false;
}


$sql_portal_empresa = "INSERT INTO portal_user_empresa (usuario_id, empresa_id, active) VALUES (:usuario_id, :empresa_id, 1)";
$stmt2 = $pdo->prepare($sql_portal_empresa);
$stmt2->bindParam(':usuario_id', $usuario_id);
$stmt2->bindParam(':empresa_id', $empresa_id);

if ($stmt2->execute()) {
    $cont_insert2 = true;
} else {
    $cont_insert2 = false;
}

if ($cont_insert1 && $cont_insert2) {
    echo "<p style='color:green;'>Cadastrado com Sucesso</p>";
} else {
    echo "<p style='color:red;'>Erro ao cadastrar</p>";
}
