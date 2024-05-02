<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";
require "../../../conexoes/conexao.php";

$submenu_id = "22";
$uid = $_SESSION['id'];
$permissions_submenu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    $dados_usuario =
        "SELECT
    u.empresa_id as empresaID,
    e.atributoEmpresaPropria  as atributoEmpresaPropria
    FROM usuarios as u
    LEFT JOIN empresas as e ON e.id = u.empresa_id
    LEFT JOIN redeneutra_parceiro as rnp ON rnp.empresa_id = u.empresa_id
    WHERE u.id = $uid";

    $r_dados_usuario = mysqli_query($mysqli, $dados_usuario);
    $c_dados_usuario = $r_dados_usuario->fetch_array();
    $empresaID = $c_dados_usuario['empresaID'];

    $count_inc_gpon =
        "SELECT count(i.id) as qtde
        FROM incidentes as i
        INNER JOIN gpon_olts o ON i.equipamento_id = o.equipamento_id
        INNER JOIN gpon_olts_interessados oi ON o.id = oi.gpon_olt_id
        WHERE i.active = 1 and oi.active = 1 and oi.interessado_empresa_id = $empresaID and i.incident_type = 100";

    $r_inc_gpon = mysqli_query($mysqli, $count_inc_gpon);
    $c_inc_gpon = $r_inc_gpon->fetch_array();

    $count_inc_backbone =
        "SELECT
    count(i.id) as qtde
    FROM incidentes as i
    INNER JOIN rotas_fibra as rf ON i.equipamento_id = rf.codigo
    INNER JOIN rotas_fibras_interessados as rfi ON rf.id = rfi.rf_id
    WHERE rfi.interessado_empresa_id =  $empresaID AND i.active = 1 AND rfi.active = 1 and i.incident_type = 102";

    $r_inc_backbone = mysqli_query($mysqli, $count_inc_backbone);
    $c_inc_backbone = $r_inc_backbone->fetch_array();

    $count_man_prog_af_gpon =
        "SELECT COUNT(*) as qtde
    FROM (
        SELECT mp.id
        FROM manutencao_programada as mp
        LEFT JOIN manutencao_gpon as mg ON mg.manutencao_id = mp.id
        LEFT JOIN gpon_pon as gp on gp.id = mg.pon_id
        LEFT JOIN gpon_olts as go on go.id = gp.olt_id
        LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = go.id
        WHERE mp.active = 1 AND goi.interessado_empresa_id = $empresaID AND goi.active = 1
        GROUP BY mp.id
    ) AS subquery;";

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
        (isset($c_man_prog_af_gpon['qtde']) && $c_man_prog_af_gpon['qtde'] > 0 ? $c_man_prog_af_gpon['qtde'] : 0);  ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>INFORMATIVOS</h1>
        </div><!-- End Page Title -->
        <br><br>
        <section class="section dashboard">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                        <?php
                        $permite_incidentes_gpon = "SELECT COUNT(*) AS count FROM incidentes_types_empresa as ite WHERE ite.empresa_id = $empresaID AND ite.incidente_type_id = 1";
                        $stmt = $pdo->query($permite_incidentes_gpon);
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result['count'] > 0) {  ?>
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card sales-card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Incidentes GPON</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-ticket-perforated"></i>
                                            </div>
                                            <div class="ps-3 text-center">
                                                <h4>
                                                    <a style="color: red;" href="/servicedesk/incidentes/informativos/gpon/informativos_gpon.php">
                                                        <?php
                                                        if ($c_inc_gpon['qtde'] > 1) {
                                                            echo $c_inc_gpon['qtde'] . " Incidentes";
                                                        } else {
                                                            echo $c_inc_gpon['qtde'] . " Incidente";
                                                        }
                                                        ?>
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>

                        <?php
                        $permite_incidentes_backbone = "SELECT COUNT(*) AS count FROM incidentes_types_empresa as ite WHERE ite.empresa_id = $empresaID AND ite.incidente_type_id = 3";
                        $stmt = $pdo->query($permite_incidentes_backbone);
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result['count'] > 0) {  ?>
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card sales-card text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">Incidentes Backbone</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-ticket-perforated"></i>
                                            </div>
                                            <div class="ps-3 text-center">
                                                <h4>
                                                    <a style="color: red;" href="/servicedesk/incidentes/informativos/backbone/informativos_backbone.php">
                                                        <?php
                                                        if ($c_inc_backbone['qtde'] > 1) {
                                                            echo $c_inc_backbone['qtde'] . " Incidentes";
                                                        } else {
                                                            echo $c_inc_backbone['qtde'] . " Incidente";
                                                        }
                                                        ?>
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Manutenções Programadas</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-ticket-perforated"></i>
                                        </div>
                                        <div class="ps-3 text-center">
                                            <h4>
                                                <a style="color: red;" href="/servicedesk/incidentes/informativos/manutencao_programada/informativos_mp.php">
                                                    <?php
                                                    if ($c_inc_backbone['qtde'] > 1) {
                                                        echo $total_mp . " Manutenções Programadas";
                                                    } else {
                                                        echo $total_mp . " Manutenções Programadas";
                                                    }
                                                    ?>
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <?php
                        $incidentes_types_query = "SELECT * FROM incidentes_types as it WHERE it.active = 1 AND it.default = 0";
                        $incidentes_types_stmt = $pdo->prepare($incidentes_types_query);
                        $incidentes_types_stmt->execute();
                        $incidentes_types_result = $incidentes_types_stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($incidentes_types_result as $incidente) {
                            $incidente_code = $incidente['codigo'];
                            $incidente_type_id = $incidente['id'];


                            $permite_incidentes_outros = "SELECT COUNT(*) AS count FROM incidentes_types_empresa as ite WHERE ite.empresa_id = $empresaID AND ite.incidente_type_id = $incidente_type_id";
                            $stmt = $pdo->query($permite_incidentes_outros);
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($result['count'] > 0) {


                                $count_inc =
                                    "SELECT
                                count(i.id) as qtde
                                FROM incidentes as i
                                WHERE i.active = 1 and i.incident_type = $incidente_code";

                                $r_inc = mysqli_query($mysqli, $count_inc);
                                $c_inc = $r_inc->fetch_array(); ?>

                                <div class="col-xxl-3 col-md-6">
                                    <div class="card info-card sales-card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">Incidentes <?= $incidente['type'] ?></h5>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-ticket-perforated"></i>
                                                </div>
                                                <div class="ps-3 text-center">
                                                    <h4>
                                                        <a style="color: red;" href="/servicedesk/incidentes/informativos/outros/informativos_outros.php?code=<?= $incidente_code ?>">
                                                            <?php
                                                            if ($c_inc['qtde'] > 1) {
                                                                echo $c_inc['qtde'] . " Incidentes";
                                                            } else {
                                                                echo $c_inc['qtde'] . " Incidente";
                                                            }
                                                            ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>

            </div>
        </section>

    </main>

<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>