<?php
include_once("../../../conexoes/conexao.php");


$id = $_POST['id'];
$tipo = $_POST['tipo'];

$sql = "UPDATE `tipos_chamados` SET `tipo`= '$tipo' WHERE id = '$id' ";
$res_sql = mysqli_query($mysqli, $sql);


if (mysqli_affected_rows($mysqli)) {
	header("Location: /portal/tipos_chamados/index.php");
}
else{
	header("Location: /portal/tipos_chamados/index.php");
}
