<?php
require "sql_dashboard_3.php";
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
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <h5 class="card-title">Últimas 10 ONUs Provisionadas</h5>
                                    <table class="table table-striped" id="styleTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Descrição</th>
                                                <th scope="col">OLT</th>
                                                <th scope="col">SLOT</th>
                                                <th scope="col">PON</th>
                                                <th scope="col">ID</th>
                                                <th scope="col">Serial</th>
                                                <th scope="col">Data Provisionamento</th>
                                                <th scope="col">Provisionado por</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            while ($c_last_10_onu = $r_last_10_onu->fetch_array()) { ?>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <a style="color: red;" href="/redeNeutra/onus_Provisionadas/view.php?idProvisionamento=<?= $c_last_10_onu['id'] ?>"><?= $c_last_10_onu['descricao'] ?></a>
                                                    </td>
                                                    <td><?= $c_last_10_onu['olt'] ?></th>
                                                    <td><?= $c_last_10_onu['slot'] ?></td>
                                                    <td><?= $c_last_10_onu['pon'] ?></td>
                                                    <td><?= $c_last_10_onu['idONU'] ?></td>
                                                    <td><?= $c_last_10_onu['serialONU'] ?></td>
                                                    <td><?= $c_last_10_onu['dataP'] ?></td>
                                                    <td><?= $c_last_10_onu['provisionado'] ?></td>
                                                </tr>
                                            <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <h5 class="card-title">ONUs POR OLT</h5>
                                    <table class="table table-striped" id="styleTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">OLT</th>
                                                <th scope="col">Quantidade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($c_onu_olt = $r_onu_olt->fetch_array()) { ?>
                                                <tr>
                                                    <td><?= $c_onu_olt['olt'] ?></th>
                                                    <td><?= $c_onu_olt['qtde'] ?></td>
                                                </tr>
                                            <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>