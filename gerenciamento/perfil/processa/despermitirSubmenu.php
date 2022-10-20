<?php
require "../../../conexoes/conexao_pdo.php";

$idPermissao = $_POST['submenu_idPermissao'];

$sql = "DELETE FROM perfil_permissoes_submenu WHERE id=?";
$stmt= $pdo->prepare($sql);
$stmt->execute([$idPermissao]);