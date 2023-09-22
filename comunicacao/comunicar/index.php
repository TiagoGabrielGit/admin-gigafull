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

	$com_aberta =
		"SELECT
			c.id as idComunicacao,
			c.msgEmail as msgEmail
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
		} else {
			// Nenhuma comunicação em aberto foi encontrada, então crie uma nova.
			$novaComunicacao = "INSERT INTO comunicacao (usuario_criador, status) VALUES (:uid, 1)";
			$stmt = $pdo->prepare($novaComunicacao);
			$stmt->bindParam(':uid', $uid);

			if ($stmt->execute()) {
				$idComunicacao = $pdo->lastInsertId();
				$msgEmail = "";
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

						<div class="row">
							<div class="col-lg-6">

								<span>Comunicação via E-mail</span>
								<hr class="sidebar-divider">

								<form method="POST" action="processa/adiciona_destinatarios_email.php">
									<input readonly hidden value="<?= $idComunicacao ?>" id="idComunicacao" name="idComunicacao"></input>

									<div class="row">

										<div class="col-8">
											<label class="form-label">Destinatários</label>
											<select id="empresa_notificacao_id" name="empresa_notificacao_id" class="form-select">
												<option disabled selected value="">Selecione...</option>
												<?php
												$dest_email =
													"SELECT
														e.fantasia as empresa,
														en.midia as email,
														en.id as idComunicacao
													FROM empresas_notificacao as en
													LEFT JOIN empresas as e ON en.empresa_id = e.id
													WHERE en.active = 1
													AND en.metodo_id = 1
                                                    AND en.id NOT IN (SELECT
														empresa_notificacao_id
														FROM
														comunicacao_destinatarios
														WHERE
														active = 1
														AND
														comunicacao_id = $idComunicacao)";

												$r_dest_email = mysqli_query($mysqli, $dest_email) or die("Erro ao retornar dados");
												while ($c_dest_email = $r_dest_email->fetch_assoc()) : ?>
													<option value="<?= $c_dest_email['idComunicacao']; ?>"><?= $c_dest_email['empresa'] . " - " . $c_dest_email['email'] ?> </option>
												<?php endwhile; ?>
											</select>
										</div>
										<div style="margin-top: 35px;" class="col-4">
											<button type="submit" class="btn btn-sm btn-danger"> Adicionar</button>
										</div>
									</div>
								</form>
								<hr class="sidebar-divider">
								<span><b>Lista Destinatários</b></span>
								<br><br>
								<?php
								$lista_email_dest =
									"SELECT
											e.fantasia,
											en.midia,
											cd.id as idComDest
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
								<div class="col-lg-6">
									<hr class="sidebar-divider">
									<div class="col-12">
										<label for="msgEmail" class="form-label">Mensagem</label>
										<textarea rows="10" name="msgEmail" id="msgEmail" class="form-control" type="text"><?= $msgEmail ?></textarea>
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
		</section>
	</main>

<?php
} else {
	require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>