<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "39";
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
    $id = $_GET['id'];

    $comunicacao =
        "SELECT
			c.id as id,
			c.msgEmail as msgEmail,
            C.status as status
			FROM
			comunicacao as c
			WHERE
			c.id = :id";
    $r_comunicacao = $pdo->prepare($comunicacao);
    $r_comunicacao->bindParam(':id', $id, PDO::PARAM_INT); // Vincula o parâmetro :uid como um inteiro


    if ($r_comunicacao->execute()) {
        $c_comunicacao = $r_comunicacao->fetch(PDO::FETCH_ASSOC);

        if ($c_comunicacao !== false) {
            $msgEmail = $c_comunicacao['msgEmail'];
            $status = $c_comunicacao['status'];
        }
    }
?>

    <main id="main" class="main">
        <section class="section">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="text-left">
                                <h5 class="card-title">Gerenciar Comunicação</h5>
                            </div>
                            <div class="text-end">
                                <?php
                                if ($status == 1) { ?>
                                    <a href="/comunicacao/comunicar/index.php?<?= $id ?>" class="btn btn-sm btn-danger">Ir para Comunicado</a>
                                <?php }
                                ?>
                            </div>
                        </div>
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