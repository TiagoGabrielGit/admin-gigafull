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
		c.msgEmail as msgEmail,
		c.step as step
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
			c.incidente_id as incidente_id,
			c.step as step
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
				$step = $result['step'];
			} else {
				// Nenhuma comunicação em aberto foi encontrada, então crie uma nova.
				$novaComunicacao = "INSERT INTO comunicacao (usuario_criador, created, status, step) VALUES (:uid, NOW(), 1, 1)";
				$stmt = $pdo->prepare($novaComunicacao);
				$stmt->bindParam(':uid', $uid);

				if ($stmt->execute()) {
					$idComunicacao = $pdo->lastInsertId();
					$step = "1";
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
						<h5 class="card-title">Comunicação <?= $idComunicacao ?> - Passo <?= $step ?></h5>

						<?php
						if ($step == 1) {
							require "step1.php";
						} else if ($step == 2) {
							require "step2.php";
						} else if ($step == 3) {
							require "step3.php";
						}
						?>

					</div>
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