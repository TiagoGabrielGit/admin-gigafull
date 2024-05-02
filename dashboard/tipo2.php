<?php
require "sql_dashboard_2.php";
?>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <?php
                $permite_incidentes_gpon = "SELECT COUNT(*) AS count FROM incidentes_types_empresa as ite WHERE ite.empresa_id = $empresaID AND ite.incidente_type_id = 1";
                $stmt = $pdo->query($permite_incidentes_gpon);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] > 0) { ?>
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card customers-card text-center">
                            <div class="card-body">
                                <h4 class="card-title">Incidentes GPON</h4>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-ticket"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h4 class="centered-text">
                                            <a style="color: red;" href="/servicedesk/incidentes/informativos/gpon/informativos_gpon.php">
                                                <?php if ($c_inc_gpon['qtde'] > 1) {
                                                    echo $c_inc_gpon['qtde'] . " Incidentes";
                                                } else {
                                                    echo $c_inc_gpon['qtde'] . " Incidente";
                                                } ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }

                $permite_incidentes_backbone = "SELECT COUNT(*) AS count FROM incidentes_types_empresa as ite WHERE ite.empresa_id = $empresaID AND ite.incidente_type_id = 3";
                $stmt = $pdo->query($permite_incidentes_backbone);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] > 0) { ?>
                    <div class="col-xxl-3 col-md-3">
                        <div class="card info-card customers-card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Incidentes Backbone</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-ticket-perforated"></i>
                                    </div>
                                    <div class="ps-3 text-center">
                                        <h4>
                                            <a style="color: red;" href="/servicedesk/incidentes/informativos/backbone/informativos_backbone.php">
                                                <?php if ($c_inc_backbone['qtde'] > 1) {
                                                    echo $c_inc_backbone['qtde'] . " Incidentes";
                                                } else {
                                                    echo $c_inc_backbone['qtde'] . " Incidente";
                                                } ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card customers-card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Manutenção Programada</h4>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-ticket"></i>
                                </div>
                                <div class="ps-3">
                                    <h4>
                                        <a style="color: red;" href="/servicedesk/incidentes/informativos/manutencao_programada/informativos_mp.php">
                                            <?php
                                            if ($total_mp == 0) {
                                                echo "Nenhuma manutenção";
                                            } else if ($total_mp == 1) {
                                                echo "1 Manutenção";
                                            } else {
                                                echo $total_mp . " Manutenções";
                                            } ?>
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
                            <div class="card info-card customers-card text-center">

                                <div class="card-body">
                                    <h5 class="card-title">Incidentes <?= $incidente['type'] ?></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-ticket"></i>
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