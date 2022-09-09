<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$idUsuario = $_GET["idUsuario"];
$idCredencial = $_GET["idCredencial"];
$tipoCredencial = $_GET["tipoCredencial"];

$cont_insert = false;

$insert_permissao_usuario = "INSERT INTO credenciais_privacidade_usuario (tipo, credencial_id, usuario_id) 
                            VALUES (:tipo, :idCredencial, :idUsuario)";
$stmt1 = $pdo->prepare($insert_permissao_usuario);
$stmt1->bindParam(':idCredencial', $idCredencial);
$stmt1->bindParam(':idUsuario', $idUsuario);
$stmt1->bindParam(':tipo', $tipoCredencial);

if ($stmt1->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}