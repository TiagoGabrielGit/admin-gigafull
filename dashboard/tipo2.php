<?php
require "sql_dashboard_2.php";
?>

<section class="section dashboard">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h4 class="card-title">Abertos</h4>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-ticket"></i>
                            </div>
                            <div class="ps-3">
                                <h4>
                                    <?= $campos_chamados_abertos['quantidade'] ?>
                                    <?php
                                    if ($campos_chamados_abertos['quantidade'] < 2) {
                                        echo "<span>Chamado</span>";
                                    } else {
                                        echo "<span>Chamados</span>";
                                    }
                                    ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Chamados em Execução</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>
                            <div class="ps-3">
                                <h4>
                                    <?= $c_count_chamados_execucao['quantidade'] ?>
                                    <?php
                                    if ($c_count_chamados_execucao['quantidade'] < 2) {
                                        echo "<span>Chamado</span>";
                                    } else {
                                        echo "<span>Chamados</span>";
                                    }
                                    ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xxl-3 col-md-6">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Incidentes</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-ticket-detailed"></i>
                            </div>
                            <div class="ps-3">
                                <h4>
                                   Devs
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Últimos 30 chamados</h5>
                        <table class="table table-striped" id="styleTable">
                            <thead>
                                <tr>
                                    <th scope="col">Número</th>
                                    <th scope="col">Tipo chamado</th>
                                    <th scope="col">Chamado</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($campos_ultimos_30_chamados = $r_ultimos_30_chamados->fetch_array()) { ?>
                                    <tr onclick="location.href='/servicedesk/consultar_chamados/view.php?id=<?= $campos_ultimos_30_chamados['idChamado'] ?>'">
                                        <td><?= $campos_ultimos_30_chamados['idChamado'] ?></th>
                                        <td><?= $campos_ultimos_30_chamados['tipoChamado'] ?></td>
                                        <td><?= $campos_ultimos_30_chamados['assuntoChamado'] ?></td>
                                        <?php
                                        $statusChamado = $campos_ultimos_30_chamados['statusChamado'];
                                        if ($statusChamado == 1) { ?>
                                            <td><span class="badge bg-success">Aberto</span></td>
                                        <?php } else if ($statusChamado == 2) { ?>
                                            <td><span class="badge bg-info">Andamento</span></td>
                                        <?php } else if ($statusChamado == 3) { ?>
                                            <td><span class="badge bg-secondary">Fechado</span></td>
                                        <?php } ?>
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
</section>