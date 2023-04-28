<?php
require "../../../conexoes/conexao_pdo.php";

$idPermissao = $_POST['idPermissao'];

$sql = "DELETE FROM perfil_permissoes_menu WHERE id=?";
$stmt= $pdo->prepare($sql);
$stmt->execute([$idPermissao]);