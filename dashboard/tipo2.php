<?php
require "sql_dashboard_2.php";
?>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
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
                                        <a style="color: red;" href="/servicedesk/incidentes/abertos.php">
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
                                        <a style="color: red;" href="/servicedesk/incidentes/abertos.php">
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

                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card customers-card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Incidentes Outros</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                                <div class="ps-3 text-center">
                                    <h4>
                                        <a style="color: red;" href="/servicedesk/incidentes/abertos.php">
                                            <?php if ($c_inc_outros['qtde'] > 1) {
                                                echo $c_inc_outros['qtde'] . " Incidentes";
                                            } else {
                                                echo $c_inc_outros['qtde'] . " Incidente";
                                            } ?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <a style="color: red;" href="/servicedesk/incidentes/abertos.php">
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
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reincidencia de Incidentes GPON Últimos 60d</h5>
                    <table class="table table-striped" id="styleTable">
                        <thead>
                            <tr>
                                <th scope="col">OLT</th>
                                <th scope="col">Cidade</th>
                                <th scope="col">Bairro</th>
                                <th scope="col">SLOT</th>
                                <th scope="col">PON</th>
                                <th scope="col">Classificação</th>
                                <th scope="col">Quantidade</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($c_incidentes_gpon_reincidentes = $r_incidentes_gpon_reincidentes->fetch_array()) { ?>
                                <tr>
                                    <td><?= $c_incidentes_gpon_reincidentes['olt_name'] ?></th>
                                    <td><?= $c_incidentes_gpon_reincidentes['cidade'] ?></td>
                                    <td><?= $c_incidentes_gpon_reincidentes['bairro'] ?></td>
                                    <td><?= $c_incidentes_gpon_reincidentes['slot'] ?></td>
                                    <td><?= $c_incidentes_gpon_reincidentes['pon'] ?></td>
                                    <td><?= $c_incidentes_gpon_reincidentes['classificacao'] ?></td>
                                    <td><?= $c_incidentes_gpon_reincidentes['quantidade_incidentes'] ?></td>


                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>