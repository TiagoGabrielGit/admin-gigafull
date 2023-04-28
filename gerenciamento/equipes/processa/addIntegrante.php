<?php
require "../../../conexoes/conexao_pdo.php";

$idEquipe = $_POST['idEquipeForm'];
$idUsuario = $_POST['idUsuarioForm'];

$cont_insert = false;

$insert_integrante = "INSERT INTO equipes_integrantes (equipe_id, integrante_id) VALUES (:idEquipe, :idUsuario)";
$stmt1 = $pdo->prepare($insert_integrante);
$stmt1->bindParam(':idEquipe', $idEquipe);
$stmt1->bindParam(':idUsuario', $idUsuario);

if ($stmt1->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}