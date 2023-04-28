<?php
require "../../../conexoes/conexao.php";

$chamado_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$pessoa_id = filter_input(INPUT_GET, 'pessoa', FILTER_SANITIZE_NUMBER_INT);

$sql = "UPDATE `chamados` SET `in_execution`= '1', `in_execution_atd_id`= '$pessoa_id', `in_execution_start`= NOW() WHERE id = '$chamado_id' ";
$res = mysqli_query($mysqli, $sql);


if (mysqli_affected_rows($mysqli)) {
	header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
}
else{
	header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
}
