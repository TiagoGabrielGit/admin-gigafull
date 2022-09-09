<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$idEquipe = $_GET["idEquipe"];
$idCredencial = $_GET["idCredencial"];
$tipoCred = $_GET["tipoCredencial"];

$insert_permissao_equipe = "INSERT INTO credenciais_privacidade_equipe (tipo, credencial_id, equipe_id) 
                            VALUES (:tipo, :idCredencial, :idEquipe)";
$stmt1 = $pdo->prepare($insert_permissao_equipe);
$stmt1->bindParam(':idCredencial', $idCredencial);
$stmt1->bindParam(':idEquipe', $idEquipe);
$stmt1->bindParam(':tipo', $tipoCred);

$stmt1->execute();