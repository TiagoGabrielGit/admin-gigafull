<?php
require "../../../conexoes/conexao_pdo.php";

$idMenu = $_POST['idMenu'];
$idPerfil = $_POST['idPerfil'];

$insert_permissao = "INSERT INTO perfil_permissoes_menu (perfil_id, url_menu) VALUES (:perfil_id, :url_menu)";
$stmt1 = $pdo->prepare($insert_permissao);
$stmt1->bindParam(':perfil_id', $idPerfil);
$stmt1->bindParam(':url_menu', $idMenu);

$stmt1->execute();