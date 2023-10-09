<?php
require "sql_dashboard_3.php";
?>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card customers-card">
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
                    <div class="card info-card customers-card">
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
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Incidentes Outros</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                                <div class="ps-3 text-center">
                                    <h4>
                                        <span>Em Desenvolvimento</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card customers-card">
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
</section>