<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "22";
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
    $tab_man_programada = "";
    $nav_man_programada = "";
    $tab_outros = "";
    $nav_outros = "";

    $count_inc_gpon =
        "SELECT
    count(i.id) as qtde
    FROM
    incidentes as i
    INNER JOIN gpon_olts o ON i.equipamento_id = o.equipamento_id
    INNER JOIN gpon_olts_interessados oi ON o.id = oi.gpon_olt_id
    WHERE
    i.active = 1
    and
    oi.active = 1
    and
    oi.interessado_empresa_id = $empresaID
    and
    i.incident_type = 100";

    $r_inc_gpon = mysqli_query($mysqli, $count_inc_gpon);
    $c_inc_gpon = $r_inc_gpon->fetch_array();

    $count_inc_backb =
        "SELECT
        count(i.id) as qtde
        FROM
        incidentes as i
        INNER JOIN rotas_fibra as rf ON i.equipamento_id = rf.codigo
        INNER JOIN rotas_fibras_interessados as rfi ON rf.id = rfi.rf_id
        WHERE rfi.interessado_empresa_id =  $empresaID AND i.active = 1 AND rfi.active = 1 and i.incident_type = 102";

    $r_inc_backb = mysqli_query($mysqli, $count_inc_backb);
    $c_inc_backb = $r_inc_backb->fetch_array();

    $count_man_prog_af_gpon =
        "SELECT count(*) as qtde
        FROM manutencao_programada as mp
        LEFT JOIN manutencao_gpon as mg ON mg.manutencao_id = mp.id
        LEFT JOIN gpon_pon as gp on gp.id = mg.pon_id
        LEFT JOIN gpon_olts as go on go.id = gp.olt_id
        LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = go.id
        where mp.active = 1   and goi.interessado_empresa_id = $empresaID and goi.active = 1
        GROUP BY mp.id
        ";

    $r_man_prog_af_gpon = mysqli_query($mysqli, $count_man_prog_af_gpon);
    $c_man_prog_af_gpon = $r_man_prog_af_gpon->fetch_array();

    $count_man_prog_af_backbone =
        "SELECT count(*) as qtde
    FROM
    manutencao_programada as mp
    LEFT JOIN manutencao_rotas_fibra as mrf ON mrf.manutencao_id = mp.id
    LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = mrf.rota_id
    where
    mp.active = 1  and rfi.interessado_empresa_id = $empresaID  and rfi.active = 1 
    GROUP BY mp.id";

    $r_man_prog_af_backbone = mysqli_query($mysqli, $count_man_prog_af_backbone);
    $c_man_prog_af_backbone = $r_man_prog_af_backbone->fetch_array();

    $total_mp = (isset($c_man_prog_af_backbone['qtde']) && $c_man_prog_af_backbone['qtde'] > 0 ? $c_man_prog_af_backbone['qtde'] : 0) +
        (isset($c_man_prog_af_gpon['qtde']) && $c_man_prog_af_gpon['qtde'] > 0 ? $c_man_prog_af_gpon['qtde'] : 0);

    $count_inc_oth =
        "SELECT
        count(id) as qtde
        FROM
        incidentes as i
        WHERE
        i.active = 1
        and
        i.incident_type <> 100
            and
        i.incident_type <> 102";

    $r_inc_oth = mysqli_query($mysqli, $count_inc_oth);
    $c_inc_oth = $r_inc_oth->fetch_array();
?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h5 class="card-title">INCIDENTES</h5>
                                </div>

                            </div>
                            <!-- Default Tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_gpon ?>" id="gpon-tab" data-bs-toggle="tab" data-bs-target="#gpon" type="button" role="tab" aria-controls="gpon" aria-selected="true">GPON
                                        <?php
                                        if ($c_inc_gpon['qtde'] > 0) {    ?>
                                            <span class="badge bg-danger text-white"><?= $c_inc_gpon['qtde'] ?></span>
                                        <?php } ?>
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_backbone ?>" id="backbone-tab" data-bs-toggle="tab" data-bs-target="#backbone" type="button" role="tab" aria-controls="backbone" aria-selected="false">Backbone
                                        <?php
                                        if ($c_inc_backb['qtde'] > 0) {    ?>
                                            <span class="badge bg-danger text-white"><?= $c_inc_backb['qtde'] ?></span>
                                        <?php } ?>
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_man_programada ?>" id="man_programada-tab" data-bs-toggle="tab" data-bs-target="#man_programada" type="button" role="tab" aria-controls="man_programada" aria-selected="false">Manutenção Programada


                                        <?php
                                        if ($total_mp > 0) {    ?>
                                            <span class="badge bg-danger text-white"><?= $total_mp ?></span>
                                        <?php } ?>

                                    </button>
                                </li>


                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_outros ?>" id="outros-tab" data-bs-toggle="tab" data-bs-target="#outros" type="button" role="tab" aria-controls="outros" aria-selected="false">Outros
                                        <?php
                                        if ($c_inc_oth['qtde'] > 0) {    ?>
                                            <span class="badge bg-danger text-white"><?= $c_inc_oth['qtde'] ?></span>
                                        <?php } ?>
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content pt-2" id="myTabContent">
                                <div class="tab-pane fade <?= $tab_gpon ?>" id="gpon" role="tabpanel" aria-labelledby="gpon-tab">
                                    <?php
                                    require "tabs/aberto_gpon.php";
                                    ?>
                                </div>

                                <div class="tab-pane fade <?= $tab_backbone ?>" id="backbone" role="tabpanel" aria-labelledby="backbone-tab">
                                    <?php
                                    require "tabs/aberto_backbone.php";
                                    ?>
                                </div>

                                <div class="tab-pane fade <?= $tab_man_programada ?>" id="man_programada" role="tabpanel" aria-labelledby="man_programada-tab">
                                    <?php
                                    require "tabs/aberto_man_programada.php";
                                    ?>
                                </div>

                                <div class="tab-pane fade <?= $tab_outros ?>" id="outros" role="tabpanel" aria-labelledby="outros-tab">
                                    <?php
                                    require "tabs/aberto_outros.php";
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