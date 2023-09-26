<?php
$dados_comunicacao =
	"SELECT ct.titulo as titulo, ct.template
FROM comunicacao as c
LEFT JOIN comunicacao_templates as ct ON c.template_email = ct.id
WHERE c.id = :idComunicacao
";

$r_comunicacao = $pdo->prepare($dados_comunicacao);
$r_comunicacao->bindParam(':idComunicacao', $idComunicacao, PDO::PARAM_INT); // Vincula o parâmetro :uid como um inteiro

$r_comunicacao->execute();
$result_comunicacao = $r_comunicacao->fetch(PDO::FETCH_ASSOC);

if ($result_comunicacao !== false) {
	$assuntoEmail = $result_comunicacao['titulo'];
	$templateEmail = $result_comunicacao['template'];
}
?>


<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-6">

			<hr class="sidebar-divider">
			<span><b>Destinatários</b></span><br><br>
			<?php
			$lista_email_dest =
				"SELECT e.fantasia, en.midia, cd.id as idComDest
											FROM comunicacao_destinatarios as cd
											LEFT JOIN empresas_notificacao as en ON cd.empresa_notificacao_id = en.id
											LEFT JOIN empresas as e ON e.id = en.empresa_id
											WHERE cd.comunicacao_id = $idComunicacao AND cd.active = 1
											ORDER BY e.fantasia ASC, en.midia ASC
											";

			$r_lista_email_dest = mysqli_query($mysqli, $lista_email_dest) or die("Erro ao retornar dados");

			while ($c_lista_email_dest = $r_lista_email_dest->fetch_assoc()) : ?>
				<div style="margin-top: 2px;" class="col-12">
					<span>
						<div class="row">
							<form method="POST" action="processa/remover_destinatario.php">
								<input hidden readonly id="comDest" name="comDest" value="<?= $c_lista_email_dest['idComDest'] ?>"></input>
								<button title="Remover Destinatário" type="submit" class="badge rounded-pill bg-danger">X</button>
								<?= $c_lista_email_dest['fantasia'] . " - " . $c_lista_email_dest['midia'] ?>
							</form>
						</div>
					</span>
				</div>
			<?php endwhile; ?>
		</div>
		<div class="col-lg-6">
			<hr class="sidebar-divider">
			<span><b>Pontos Afetados</b></span><br><br>
			<?php
			if (isset($result['incidente_id'])) {
				$id_incidente = $result['incidente_id'];
				$sql_incidentes =
					"SELECT equipamento_id, incident_type
											FROM incidentes
											WHERE id = :id_incidente";

				$r_incidente = $pdo->prepare($sql_incidentes); // Corrigido para usar $sql_incidentes
				$r_incidente->bindParam(':id_incidente', $id_incidente, PDO::PARAM_INT);

				if ($r_incidente->execute()) {
					$result_incidente = $r_incidente->fetch(PDO::FETCH_ASSOC);

					if ($result_incidente !== false && $result_incidente['incident_type'] == 100) {
						$equipamento_id = $result_incidente['equipamento_id'];

						$sql_incidentes_pons =
							"SELECT gpo.olt_name as olt, gpp.slot as slot, gpp.pon as pon, gpl.cidade as cidade, gpl.bairro as bairro
												FROM incidentes as i
												LEFT JOIN gpon_pon as gpp ON gpp.id = i.pon_id
												LEFT JOIN gpon_localidades as gpl ON gpl.pon_id = i.pon_id
												LEFT JOIN gpon_olts as gpo ON gpo.id = gpp.olt_id
												WHERE i.equipamento_id = :equipamento_id and i.active = 1";

						$r_incidentes_pons = $pdo->prepare($sql_incidentes_pons);
						$r_incidentes_pons->bindParam(':equipamento_id', $equipamento_id, PDO::PARAM_INT);

						if ($r_incidentes_pons->execute()) {
							while ($result_incidentes_pons = $r_incidentes_pons->fetch(PDO::FETCH_ASSOC)) {
								$olt = $result_incidentes_pons['olt'];
								$slot = $result_incidentes_pons['slot'];
								$pon = $result_incidentes_pons['pon'];
								$cidade = $result_incidentes_pons['cidade'];
								$bairro = $result_incidentes_pons['bairro'];

								echo "Cidade: $cidade | Bairro: $bairro - OLT $olt - Slot $slot - PON $pon<br>";
							}
						}
					}
				}
			}
			?>
		</div>
	</div>
</div>



<form method="POST" action="processa/step3.php">
	<input hidden readonly id="idComunicacao" name="idComunicacao" value="<?= $idComunicacao ?>"></input>

	<div class="row"> <!-- A -->
		<div class="col-lg-12"> <!-- B -->

			<hr class="sidebar-divider">

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-8">
							<label for="assuntoEmail" class="form-label">Assunto</label>
							<input required type="text" id="assuntoEmail" name="assuntoEmail" value="<?= $assuntoEmail ?>" class="form-control"></input>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="col-12">

							<textarea id="msgEmail" name="msgEmail" class="tinymce-editor"><?= $templateEmail ?></textarea><!-- End TinyMCE Editor -->
						</div>
					</div>
				</div>
			</div>


		</div> <!-- B -->

		<hr class="sidebar-divider">
		<style>
			.equal-width-btn {
				width: 60%;
			}
		</style>

		<div class="container">
			<form method="POST" action="processa/step3.php">

				<input readonly hidden id="idComunicacao" name="idComunicacao" value="<?= $idComunicacao ?>" />

				<div class="row">
					<div class="col-3">
						<button name="acao" value="salvar_rascunho" class="btn btn-sm btn-primary equal-width-btn">Salvar Rascunho</button>
					</div>

					<div class="col-3">
						<button name="acao" value="voltar" class="btn btn-sm btn-warning equal-width-btn">Voltar</button>
					</div>

					<div class="col-3">
						<button name="acao" value="enviar" class="btn btn-sm btn-success equal-width-btn">Enviar</button>
					</div>

					<div class="col-3">
						<button name="acao" value="cancelar_comunicacao" class="btn btn-sm btn-secondary equal-width-btn">Cancelar Comunicação</button>
					</div>
				</div>
			</form>
		</div>
	</div> <!-- A -->
</form>