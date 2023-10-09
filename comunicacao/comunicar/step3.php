<?php
$dados_comunicacao =
	"SELECT ct.titulo as titulo, ct.template as template, ct.normalizacao as normalizacao
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
	$normalizacao = $result_comunicacao['normalizacao'];
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
		<?php if ($origem == 1) { ?>
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

					$r_incidente = $pdo->prepare($sql_incidentes);
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

						if ($result_incidente !== false && $result_incidente['incident_type'] == 102) {
							$equipamento_id = $result_incidente['equipamento_id'];

							$sql_incidentes_rotas =
								"SELECT rf.ponta_a as ponta_a, rf.ponta_b as ponta_b
								FROM incidentes as i
								LEFT JOIN rotas_fibra as rf ON rf.codigo = i.equipamento_id
								WHERE i.equipamento_id = :equipamento_id and i.active = 1";

							$r_incidentes_rotas = $pdo->prepare($sql_incidentes_rotas);
							$r_incidentes_rotas->bindParam(':equipamento_id', $equipamento_id, PDO::PARAM_INT);

							if ($r_incidentes_rotas->execute()) {
								while ($result_incidentes_rotas = $r_incidentes_rotas->fetch(PDO::FETCH_ASSOC)) {
									$ponta_a = $result_incidentes_rotas['ponta_a'];
									$ponta_b = $result_incidentes_rotas['ponta_b'];

									echo "Ponta A: $ponta_a <--> Ponta B: $ponta_b<br>";
								}
							}
						}
					}
				}
				?>
			</div>
		<?php } else if ($origem == 2) { ?>
			<div class="col-lg-6">
				<h5 class="card-title">Rotas de Fibra</h5>
				<ul>
					<?php
					$rotas = "SELECT
                    mrf.id as idMan,
                    rf.ponta_a as ponta_a,
                    rf.ponta_b as ponta_b
                    FROM
                    manutencao_rotas_fibra as mrf
                    LEFT JOIN
                    rotas_fibra as rf
                    ON rf.id = mrf.rota_id
                    WHERE
                    mrf.manutencao_id = $origem_id";

					try {
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $pdo->prepare($rotas);
						$stmt->execute();
						$c_rotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
					} catch (PDOException $e) {
						echo "Erro na consulta SQL: " . $e->getMessage();
					}

					if (empty($c_rotas)) {
						echo "Nenhuma rota de fibra selecionada.";
					} else {
						foreach ($c_rotas as $rota) :
					?>
							<li>
								<label class="form-check-label">
									<?= $rota['ponta_a'] . " <> " .  $rota['ponta_b']  ?>
								</label>
							</li>
					<?php endforeach;
					}
					?>
				</ul>

				<h5 class="card-title">GPON</h5>
				<ul>
					<?php
					$gpon = "SELECT
                    mg.id as idMan,
                    gp.slot as slot,
                    gp.pon as pon,
                    gpo.olt_name as olt_name,
					gl.cidade as cidade,
					gl.bairro as  bairro
                    FROM manutencao_gpon as mg
                    LEFT JOIN gpon_pon as gp ON gp.id = mg.pon_id
                    LEFT JOIN gpon_olts as gpo ON gpo.id = gp.olt_id
					LEFT JOIN gpon_localidades as gl ON gl.pon_id = mg.pon_id
                    WHERE
                    mg.manutencao_id = $origem_id";

					try {
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt = $pdo->prepare($gpon);
						$stmt->execute();
						$pons = $stmt->fetchAll(PDO::FETCH_ASSOC);
					} catch (PDOException $e) {
						echo "Erro na consulta SQL: " . $e->getMessage();
					}

					if (empty($pons)) {
						echo "Nenhuma PON selecionada.";
					} else {
						foreach ($pons as $pon) :
					?>
							<li>
								<label class="form-check-label">
									<?= "OLT " . $pon['olt_name'] . " (SLOT " . $pon['slot'] . " | PON " .  $pon['pon'] . ") - Cidade: " .  $pon['cidade'] . " | Bairro: " . $pon['bairro'] ?>
								</label>
							</li>
					<?php endforeach;
					}
					?>
				</ul>
			</div>
		<?php } ?>
	</div>
</div>



<form method="POST" action="processa/step3.php">
	<input hidden readonly id="idComunicacao" name="idComunicacao" value="<?= $idComunicacao ?>"></input>
	<input hidden readonly id="normalizacao" name="normalizacao" value="<?= $normalizacao ?>"> </input>
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