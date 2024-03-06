<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (
		!isset($_POST['selectEntrega']) || $_POST['selectEntrega'] === '' ||
		!isset($_POST['id']) || $_POST['id'] === '' ||
		!isset($_POST['tipoChamadoEdit']) || $_POST['tipoChamadoEdit'] === '' ||
		!isset($_POST['situacao']) || $_POST['situacao'] === '' ||
		!isset($_POST['selectMobile']) || $_POST['selectMobile'] === '' ||
		!isset($_POST['selectAfericao']) || $_POST['selectAfericao'] === '' ||
		!isset($_POST['tipoDescricaoEdit']) || $_POST['tipoDescricaoEdit'] === ''


	) {
		echo "<p style='color:red;'>Dados obrigatórios não preenchidos¹.</p>";
	} else {
		require "../../../../conexoes/conexao_pdo.php";
		$id = $_POST['id'];
		$tipo = $_POST['tipoChamadoEdit'];
		$situacao = $_POST['situacao'];
		$permite_data_entrega = $_POST['selectEntrega'];
		$mobile = $_POST['selectMobile'];
		$selectAfericao = $_POST['selectAfericao'];
		$tipoDescricao = $_POST['tipoDescricaoEdit'];

		if ($permite_data_entrega == 1) {
			$horas_prazo_entrega = $_POST['tempoEntrega'];

			if (empty($horas_prazo_entrega)) {
				echo "<p style='color:red;'>Dados obrigatórios não preenchidos².</p>";
			} else {
				$data = [
					'id' => $id,
					'tipo' => $tipo,
					'active' => $situacao,
					'permite_data_entrega' => $permite_data_entrega,
					'horas_prazo_entrega' => $horas_prazo_entrega,
					'mobile' => $mobile,
					'selectAfericao' => $selectAfericao,
					'tipoDescricao' => $tipoDescricao,
				];

				$sql = "UPDATE tipos_chamados SET descricao=:tipoDescricao, afericao=:selectAfericao, mobile=:mobile, permite_data_entrega=:permite_data_entrega, horas_prazo_entrega=:horas_prazo_entrega, tipo=:tipo, active=:active WHERE id=:id";
				$stmt1 = $pdo->prepare($sql);

				if ($stmt1->execute($data)) {
					echo "<p style='color:green;'>Editado com sucesso!</p>";
				} else {
					echo "<p style='color:red;'>Error: " . implode(" - ", $stmt1->errorInfo()) . "</p>";
				}
			}
		} else {
			$horas_prazo_entrega = '0';

			$data = [
				'id' => $id,
				'tipo' => $tipo,
				'active' => $situacao,
				'permite_data_entrega' => $permite_data_entrega,
				'horas_prazo_entrega' => $horas_prazo_entrega,
				'mobile' => $mobile,
				'selectAfericao' => $selectAfericao,
				'tipoDescricao' => $tipoDescricao,


			];

			$sql = "UPDATE tipos_chamados SET descricao=:tipoDescricao, afericao=:selectAfericao, mobile=:mobile, permite_data_entrega=:permite_data_entrega, horas_prazo_entrega=:horas_prazo_entrega, tipo=:tipo, active=:active WHERE id=:id";
			$stmt1 = $pdo->prepare($sql);

			if ($stmt1->execute($data)) {
				echo "<p style='color:green;'>Editado com sucesso!</p>";
			} else {
				echo "<p style='color:red;'>Error: " . implode(" - ", $stmt1->errorInfo()) . "</p>";
			}
		}
	}
}
