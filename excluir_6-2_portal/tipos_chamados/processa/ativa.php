<?php
session_start();

include_once("../../../conexoes/conexao.php");

$ativa_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = "UPDATE `tipos_chamados` SET `active`= '1' WHERE id = '$ativa_id' ";
$res_sql = mysqli_query($mysqli, $sql);


if (mysqli_affected_rows($mysqli)) {
	header("Location: /portal/tipos_chamados/index.php");
}
else{
	header("Location: /portal/tipos_chamados/index.php");
}
