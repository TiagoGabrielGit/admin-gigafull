<?php
require "sql_dashboard_1.php";
?>

<section class="section dashboard">
    <div class="row">
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

                                        <form action="/servicedesk/consultar_chamados/index.php" method="POST">

                                            <input type="hidden" name="atendentePesquisa" value="0">
                                            <input type="hidden" name="statusChamado" value="!= 3">

                                            <button type="submit" style=" background: none; border: none; cursor: pointer;">
                                                <?= $campos_chamados_abertos['quantidade'] ?>
                                                <?php
                                                if ($campos_chamados_abertos['quantidade'] < 2) {
                                                    echo "<span>Chamado</span>";
                                                } else {
                                                    echo "<span>Chamados</span>";
                                                }
                                                ?>
                                            </button>
                                        </form>
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
                                        <form action="/servicedesk/consultar_chamados/index.php" method="POST">

                                            <input type="hidden" name="atendentePesquisa" value="0">
                                            <input type="hidden" name="statusChamado" value="!= 3">

                                            <button type="submit" style=" background: none; border: none; cursor: pointer;">
                                                <?= $campos_chamados_sematendentes['quantidade'] ?>
                                                <?php
                                                if ($campos_chamados_sematendentes['quantidade'] < 2) {
                                                    echo "<span>Chamado</span>";
                                                } else {
                                                    echo "<span>Chamados</span>";
                                                }
                                                ?>
                                            </button>
                                        </form>
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
                                        <form action="/servicedesk/consultar_chamados/index.php" method="POST">
                                            <input type="hidden" name="atendentePesquisa" value="<?= $_SESSION['id'] ?>">
                                            <input type="hidden" name="statusChamado" value="!= 3">

                                            <button type="submit" style=" background: none; border: none; cursor: pointer;">
                                                <?= $campos_chamados_meus['quantidade'] ?>
                                                <?php
                                                if ($campos_chamados_meus['quantidade'] < 2) {
                                                    echo '<span>Chamado</span>';
                                                } else {
                                                    echo '<span>Chamados</span>';
                                                }
                                                ?>
                                            </button>
                                        </form>
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
    </div>
    <div class="row">
        <div class="col-lg-7">
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
        <div class="col-lg-5">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">POPs Atividades</h5>
                    <table class="table table-striped" id="styleTable">
                        <thead>
                            <tr>
                                <th scope="col">POP</th>
                                <th scope="col">Atividade</th>
                                <th scope="col">Data</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php try {
                                // Prepara a consulta SQL para buscar as atividades agendadas dos POPs
                                $stmt = $pdo->prepare("SELECT 
                                CASE
                                WHEN pap.status = 1 THEN 'Programada'
                                END as status,
                                CASE
                                WHEN pap.atividade_id = 1 THEN 'Manutenção de Ar Condicionado'
                                WHEN pap.atividade_id = 2 THEN 'Troca de Bateria'
                                WHEN pap.atividade_id = 3 THEN 'Vistoria de POP'
                                END as atividade,
                                p.pop as pop, 
                                DATE_FORMAT(pap.date, '%d %m %Y') as data
                                FROM 
                                    pop_atividade_programada as pap
                                LEFT JOIN
                                    pop as p
                                ON
                                    p.id = pap.pop_id
                                WHERE
                                    pap.status = 1
                                ORDER BY data ASC");

                                // Executa a consulta
                                $stmt->execute();

                                // Obtém os resultados da consulta
                                $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Exibe os resultados na tabela
                                foreach ($atividades as $atividade) {
                                    echo '<tr>';

                                    echo '<td>' . $atividade['pop'] . '</td>';
                                    echo '<td>' . $atividade['atividade'] . '</td>';
                                    echo '<td>' . $atividade['data'] . '</td>';
                                    echo '<td>' . $atividade['status'] . '</td>';
                                    echo '</tr>';
                                }
                            } catch (PDOException $e) {
                                echo "Erro ao buscar as atividades agendadas: " . $e->getMessage();
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>

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

        </div>
    </div>
</section>