<?php
require "sql_dashboard_2.php";
?>

<section class="section dashboard">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ONUs Provisionadas</h4>
                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card ">
                                <div class="card-body">
                                    <h4 class="card-title">Total</h4>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-ticket"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h4>
                                                <?= $c_total_onu['total'] ?>
                                                <?php
                                                if ($c_total_onu['total'] < 2) {
                                                    echo "<span>ONU</span>";
                                                } else {
                                                    echo "<span>ONUs</span>";
                                                }
                                                ?>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card ">
                                <div class="card-body">
                                    <h5 class="card-title">Hoje</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-ticket-perforated"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h4>
                                                <?= $c_hoje_onu['hoje'] ?>
                                                <?php
                                                if ($c_hoje_onu['hoje'] < 2) {
                                                    echo "<span>ONU</span>";
                                                } else {
                                                    echo "<span>ONUs</span>";
                                                }
                                                ?>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card ">
                                <div class="card-body">
                                    <h5 class="card-title">Ontem</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-ticket-detailed"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h4>
                                                <?= $c_ontem['ontem'] ?>
                                                <?php
                                                if ($c_ontem['ontem'] < 2) {
                                                    echo "<span>ONU</span>";
                                                } else {
                                                    echo "<span>ONUs</span>";
                                                }
                                                ?>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card ">
                                <div class="card-body">
                                    <h5 class="card-title">Últiimos 7 dias</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-ticket-detailed"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h4>
                                                <?= $c_ultimos_7_dias['7day'] ?>
                                                <?php
                                                if ($c_ultimos_7_dias['7day'] < 2) {
                                                    echo "<span>ONU</span>";
                                                } else {
                                                    echo "<span>ONUs</span>";
                                                }
                                                ?>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div><!-- End Left side columns -->
            </div>
        </div>
    </div>
</section>