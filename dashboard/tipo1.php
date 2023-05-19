<?php
require "sql_dashboard_1.php";
?>

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
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
                            <h5 class="card-title">Chamados sem atendente</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                                <div class="ps-3">
                                    <h4>
                                        <?= $campos_chamados_sematendentes['quantidade'] ?>
                                        <?php
                                        if ($campos_chamados_sematendentes['quantidade'] < 2) {
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
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Meus chamados</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-ticket-detailed"></i>
                                </div>
                                <div class="ps-3">
                                    <h4>
                                        <?= $campos_chamados_meus['quantidade'] ?>
                                        <?php
                                        if ($campos_chamados_meus['quantidade'] < 2) {
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
                                        <a style="color: red;" href="/servicedesk/incidentes/index.php">
                                            <?= $c_incidentes['qtde'] ?>
                                            <?php
                                            if ($c_incidentes['qtde'] < 2) {
                                                echo "<span>Incidente</span>";
                                            } else {
                                                echo "<span>Incidentes</span>";
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
        </div>

        <div class="col-lg-8">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Últimos 30 chamados</h5>
                        <table class="table table-striped" id="styleTable">
                            <thead>
                                <tr>
                                    <th scope="col">Número</th>
                                    <th scope="col">Cliente</th>
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
                                        <td><?= $campos_ultimos_30_chamados['fantasia'] ?></td>
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

        <div class="col-lg-4">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">RN - ONUs Por Parceiro</h5>
                    <table class="table table-striped" id="styleTable">
                        <thead>
                            <tr>
                                <th scope="col">Parceiro</th>
                                <th scope="col">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($c_onu_parceiro = $r_onu_parceiro->fetch_array()) { ?>
                                <tr>
                                    <td><?= $c_onu_parceiro['parceiro'] ?></th>
                                    <td><?= $c_onu_parceiro['qtde'] ?></td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Horas X Clientes (mês)</h5>
                    <table class="table table-striped" id="styleTable">
                        <thead>
                            <tr>
                                <th scope="col">Período</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Horas trabalhadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($campos_sql_horas_x_clientes = $r_sql_horas_x_clientes->fetch_array()) { ?>
                                <tr>
                                    <td><?= $campos_sql_horas_x_clientes['periodo'] ?></th>
                                    <td><?= $campos_sql_horas_x_clientes['fantasia'] ?></td>
                                    <td><?= gmdate("H:i:s", $campos_sql_horas_x_clientes['tempoTrabalhado']); ?></td>
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