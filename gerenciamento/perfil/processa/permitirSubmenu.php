<?php
require "../../../conexoes/conexao_pdo.php";

$id_submenu = $_POST['idSubmenu'];
$idPerfil = $_POST['submenu_idPerfil'];

$insert_permissao = "INSERT INTO perfil_permissoes_submenu (perfil_id, url_submenu) VALUES (:perfil_id, :url_submenu)";
$stmt1 = $pdo->prepare($insert_permissao);
$stmt1->bindParam(':perfil_id', $idPerfil);
$stmt1->bindParam(':url_submenu', $id_submenu);

$stmt1->execute();


