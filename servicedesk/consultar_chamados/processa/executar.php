<?php
require "../../../conexoes/conexao.php";

$chamado_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$pessoa_id = filter_input(INPUT_GET, 'pessoa', FILTER_SANITIZE_NUMBER_INT);

$sql = "UPDATE `chamados` SET `in_execution`= '1', `in_execution_atd_id`= '$pessoa_id', `in_execution_start`= NOW() WHERE id = '$chamado_id' ";
$res = mysqli_query($mysqli, $sql);


if (mysqli_affected_rows($mysqli)) {


	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
		$protocol = 'https';
	} else {
		$protocol = 'http';
	}
	$documentRoot = $_SERVER['DOCUMENT_ROOT'];
	$url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/notificacao/mail/execucao_chamado.php';

	$data = array(
		'id_chamado' => $chamado_id
	);

	// Inicializa o cURL
	$curl = curl_init($url);

	// Configura as opções do cURL
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	// Executa a requisição cURL
	$response = curl_exec($curl);

	// Verifica se ocorreu algum erro durante a requisição
	if ($response === false) {
		header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
		exit; // Encerra a execução do script após o redirecionamento
	} else {
		header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
		exit; // Encerra a execução do script após o redirecionamento
	}
} else {
	header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
}
