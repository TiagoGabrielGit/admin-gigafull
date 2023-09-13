<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "33";
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

    require "../../conexoes/conexao.php";

    $dados_usuario =
        "SELECT
    u.empresa_id as empresaID,
    u.permissao_gerenciar_incidentes as permissaoGerenciar
    FROM
    usuarios as u
    LEFT JOIN
    redeneutra_parceiro as rnp
    ON
    rnp.empresa_id = u.empresa_id
    WHERE
    u.id =   $uid
";

    $r_dados_usuario = mysqli_query($mysqli, $dados_usuario);
    $c_dados_usuario = $r_dados_usuario->fetch_array();
    $empresaID = $c_dados_usuario['empresaID'];
    $permissaoGerenciar = $c_dados_usuario['permissaoGerenciar'];

    $tab_gpon = "show active";
    $nav_gpon = "active";
    $tab_backbone = "";
    $nav_backbone = "";
    $tab_outros = "";
    $nav_outros = "";
?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h5 class="card-title">INCIDENTES NORMALIZADOS</h5>
                                </div>

                            </div>
                            <!-- Default Tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_gpon ?>" id="gpon-tab" data-bs-toggle="tab" data-bs-target="#gpon" type="button" role="tab" aria-controls="gpon" aria-selected="true">GPON</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_backbone ?>" id="backbone-tab" data-bs-toggle="tab" data-bs-target="#backbone" type="button" role="tab" aria-controls="backbone" aria-selected="false">Backbone</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_backbone ?>" id="outros-tab" data-bs-toggle="tab" data-bs-target="#outros" type="button" role="tab" aria-controls="outros" aria-selected="false">Outros</button>
                                </li>
                            </ul>

                            <div class="tab-content pt-2" id="myTabContent">
                                <div class="tab-pane fade <?= $tab_gpon ?>" id="gpon" role="tabpanel" aria-labelledby="gpon-tab">
                                    <?php
                                    require "tabs/normalizado_gpon.php";
                                    ?>
                                </div>

                                <div class="tab-pane fade <?= $tab_backbone ?>" id="backbone" role="tabpanel" aria-labelledby="backbone-tab">
                                    <?php
                                    require "tabs/normalizado_backbone.php";
                                    ?>
                                </div>

                                <div class="tab-pane fade <?= $tab_outros ?>" id="outros" role="tabpanel" aria-labelledby="outros-tab">
                                    <?php
                                    require "tabs/normalizado_outros.php";
                                    ?>
                                </div>
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