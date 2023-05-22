<?php
session_start();

include_once("../../../conexoes/conexao.php");

$ativa_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$ativa_usuario = "UPDATE `portal_user` SET `active`= '1' WHERE id = '$ativa_id' ";
$res_ativa_usuario = mysqli_query($mysqli, $ativa_usuario);


if (mysqli_affected_rows($mysqli)) {
	header("Location: /portal/usuarios/index.php");
}
else{
	header("Location: /portal/usuarios/index.php");
}
