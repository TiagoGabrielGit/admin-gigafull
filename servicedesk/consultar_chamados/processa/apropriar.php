<?php
require "../../../conexoes/conexao.php";

$chamado_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$pessoa_id = filter_input(INPUT_GET, 'pessoa', FILTER_SANITIZE_NUMBER_INT);

$sql = "UPDATE `chamados` SET `atendente_id`= '$pessoa_id' WHERE id = '$chamado_id' ";

if ($res = mysqli_query($mysqli, $sql)) {
?>
	<script>
		setTimeout(function() {
			var chamadoId = <?= $chamado_id ?>;
			fetch('/notificacao/mail/apropriar_chamado.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: 'id_chamado=' + chamadoId
			}).then(function(response) {
				if (response.ok) {
					//Tratamento para ok
					window.location.href = "/servicedesk/consultar_chamados/view.php?id=<?= $chamado_id ?>";
				} else {
					console.error('Erro na requisição. Status:', response.status);
				}
			}).catch(function(error) {
				console.error('Erro na requisição:', error);
			});
		});
	</script>
<?php } else {
	header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
}
