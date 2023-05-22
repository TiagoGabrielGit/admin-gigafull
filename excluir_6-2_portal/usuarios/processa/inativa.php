<?php
session_start();

include_once("../../../conexoes/conexao.php");

$inativa_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$inativa_usuario = "UPDATE `portal_user` SET `active`= '0' WHERE id = '$inativa_id' ";
$res_inativa_usuario = mysqli_query($mysqli, $inativa_usuario);


if (mysqli_affected_rows($mysqli)) {
	header("Location: /portal/usuarios/index.php");
}
else{
	header("Location: /portal/usuarios/index.php");
}
