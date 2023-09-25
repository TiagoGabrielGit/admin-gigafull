<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "34";
$uid = $_SESSION['id'];

$permissions_submenu =
	"SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {


	if (isset($_GET['id'])) {
		$idComunicacao = $_GET['id'];

		$com_aberta =
			"SELECT
		c.id as idComunicacao,
		c.msgEmail as msgEmail
		FROM
		comunicacao as c
		WHERE
		c.id = :id";

		$r_com_aberta = $pdo->prepare($com_aberta);
		$r_com_aberta->bindParam(':id', $idComunicacao, PDO::PARAM_INT); // Vincula o parâmetro :uid como um inteiro
		$r_com_aberta->execute();

		$msgEmail = $result['msgEmail'];
	} else {
		$com_aberta =
			"SELECT
			c.id as idComunicacao,
			c.msgEmail as msgEmail,
			c.assuntoEmail as assuntoEmail,
			c.incidente_id as incidente_id
			FROM
			comunicacao as c
			WHERE
			c.usuario_criador = :uid
			and
			c.status = 1";
		$r_com_aberta = $pdo->prepare($com_aberta);
		$r_com_aberta->bindParam(':uid', $uid, PDO::PARAM_INT); // Vincula o parâmetro :uid como um inteiro


		if ($r_com_aberta->execute()) {
			$result = $r_com_aberta->fetch(PDO::FETCH_ASSOC);

			if ($result !== false) {
				$idComunicacao = $result['idComunicacao'];
				$msgEmail = $result['msgEmail'];
				$assuntoEmail = $result['assuntoEmail'];
			} else {
				// Nenhuma comunicação em aberto foi encontrada, então crie uma nova.
				$novaComunicacao = "INSERT INTO comunicacao (usuario_criador, created, status) VALUES (:uid, NOW(), 1)";
				$stmt = $pdo->prepare($novaComunicacao);
				$stmt->bindParam(':uid', $uid);

				if ($stmt->execute()) {
					$idComunicacao = $pdo->lastInsertId();
					$msgEmail = "";
					$assuntoEmail = "";
				}
			}
		}
	}
?>

	<main id="main" class="main">
		<section class="section">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Comunicação</h5>
						<div class="col-lg-12">
							<div class="row">
								<span>Comunicação via E-mail</span>
								<hr class="sidebar-divider">
								<div class="col-lg-6">
									<div class="row">
										<form method="POST" action="processa/adiciona_destinatarios_email.php">
											<input readonly hidden value="<?= $idComunicacao ?>" id="idComunicacao" name="idComunicacao"></input>
											<div class="col-8">
												<label class="form-label">Destinatários</label>
												<select id="empresa_notificacao_id" name="empresa_notificacao_id" class="form-select">
													<option disabled selected value="">Selecione...</option>
													<?php
													$dest_email =
														"SELECT e.fantasia as empresa, en.midia as email, en.id as idComunicacao
													FROM empresas_notificacao as en
													LEFT JOIN empresas as e ON en.empresa_id = e.id
													WHERE en.active = 1 AND en.metodo_id = 1 AND en.id NOT IN (SELECT empresa_notificacao_id
														FROM comunicacao_destinatarios
														WHERE active = 1 AND comunicacao_id = $idComunicacao)";
													$r_dest_email = mysqli_query($mysqli, $dest_email) or die("Erro ao retornar dados");
													while ($c_dest_email = $r_dest_email->fetch_assoc()) : ?>
														<option value="<?= $c_dest_email['idComunicacao']; ?>"><?= $c_dest_email['empresa'] . " - " . $c_dest_email['email'] ?> </option>
													<?php endwhile; ?>
												</select>
											</div>
											<div style="margin-top: 15px;" class="col-4">
												<button type="submit" class="btn btn-sm btn-danger"> Adicionar</button>
											</div>
										</form>
									</div>
								</div>
								<div class="col-lg-6">
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
							</div>
							<!-- 
							<div class="col-lg-6">

								<span>Comunicação via WR Gateway</span>
								<hr class="sidebar-divider">
							</div>
							-->
						</div>

						<form method="POST" action="processa/form_comunicacao.php">
							<input hidden readonly id="idComunicacao" name="idComunicacao" value="<?= $idComunicacao ?>"></input>

							<div class="row">
								<div class="col-lg-12">

									<hr class="sidebar-divider">
									<div class="col-7">
										<label for="templateEmail" class="form-label">Escolher um Template</label>
										<select class="form-select" name="templateEmail" id="templateEmail">
											<option selected disabled value="">Selecione...</option>

											<?php
											$sql =
												"SELECT
											ct.id as id,
											ct.titulo as titulo,
											ct.template as template,
											CASE
												WHEN ct.aplicado = 1 THEN 'Incidentes'
												WHEN ct.aplicado = 2 THEN 'Manutenção Programada'
											END as aplicado,
											CASE
												WHEN ct.active = 1 THEN 'Ativo'
												WHEN ct.active = 0 THEN 'Inativo'
											END as active
										FROM comunicacao_templates as ct
										WHERE ct.tipo = 1 AND ct.active = 1
										ORDER BY ct.template ASC";

											$r_sql = mysqli_query($mysqli, $sql);

											while ($c_sql = $r_sql->fetch_array()) {
											?>
												<option value="<?= $c_sql['id'] ?>"><?= $c_sql['titulo']; ?></option>
											<?php } ?>
										</select>
									</div>

									<hr class="sidebar-divider">



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
													// Agora, você pode percorrer todos os resultados usando um loop
													while ($result_incidentes_pons = $r_incidentes_pons->fetch(PDO::FETCH_ASSOC)) {
														$olt = $result_incidentes_pons['olt'];
														$slot = $result_incidentes_pons['slot'];
														$pon = $result_incidentes_pons['pon'];
														$cidade = $result_incidentes_pons['cidade'];
														$bairro = $result_incidentes_pons['bairro'];

														// Aqui você pode usar os valores ou armazená-los em uma matriz, dependendo do que deseja fazer com eles
														echo "Cidade: $cidade | Bairro: $bairro - OLT $olt - Slot $slot - PON $pon<br>";
													}
												}
											}
										}
									}
									?>

									<br>
									<div class="col-8">
										<label for="assuntoEmail" class="form-label">Assunto</label>
										<input required type="text" id="assuntoEmail" name="assuntoEmail" value="<?= $assuntoEmail ?>" class="form-control"></input>
									</div>
									<br>
									<div class="col-12">
										<label for="msgEmail" class="form-label">Mensagem</label>
										<textarea required rows="15" name="msgEmail" id="msgEmail" class="form-control" type="text"><?= $msgEmail ?></textarea>
									</div>
								</div>

								<!-- 
								<div class="col-lg-6">
									<hr class="sidebar-divider">
									<div class="col-12">
										<label for="msgWRGateway" class="form-label">Mensagem</label>
										<textarea rows="10" name="msgWRGateway" id="msgWRGateway" class="form-control" type="text"></textarea>
									</div>
								</div> 
								-->
								<hr class="sidebar-divider">
								<div class="container">
									<div class="row">
										<div class="col-4">
											<button name="acao" value="salvar_rascunho" class="btn btn-sm btn-primary">Salvar Rascunho</button>
										</div>
										<div class="col-4">
											<button name="acao" value="salvar_enviar" class="btn btn-sm btn-danger">Salvar e Enviar</button>
										</div>
										<div class="col-4">
											<button name="acao" value="cancelar_comunicacao" class="btn btn-sm btn-secondary">Cancelar Comunicação</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</main>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function() {
			// Quando o valor do select mudar
			$("#templateEmail").change(function() {
				// Pega o valor selecionado
				var templateId = $(this).val();

				$.ajax({
					type: "POST",
					url: "processa/buscar_template.php", // O arquivo PHP que irá buscar o conteúdo do template
					data: {
						templateId: templateId
					},
					success: function(response) {
						// Parse a resposta JSON (assumindo que a resposta seja em JSON)
						var templateData = JSON.parse(response);

						// Preenche #msgEmail com o valor da coluna "template"
						$("#msgEmail").val(templateData.template);

						// Preenche #assuntoEmail com o valor da coluna "titulo"
						$("#assuntoEmail").val(templateData.titulo);
					}
				});
			});
		});
	</script>

<?php
} else {
	require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>