<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST['id']) || empty($_POST['tipoChamadoEdit']) || $_POST['situacao'] === "") {
		echo "<p style='color:red;'>Dados obrigatórios não preenchidos.</p>";
	} else {
		require "../../../conexoes/conexao_pdo.php";
		$id = $_POST['id'];
		$tipo = $_POST['tipoChamadoEdit'];
		$situacao = $_POST['situacao'];

		$data = [
			'id' => $id,
			'tipo' => $tipo,
			'active' => $situacao,
		];

		$sql = "UPDATE tipos_chamados SET tipo=:tipo, active=:active WHERE id=:id";
		$stmt1 = $pdo->prepare($sql);

		if ($stmt1->execute($data)) {
			echo "<p style='color:green;'>Editado com sucesso!</p>";
		} else {
			echo "<p style='color:red;'>Error: . $stmt->error</p>";
		}
	}
}
