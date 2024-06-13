<?php
require "sql_dashboard_1.php";

?>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card sales-card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Abertos</h4>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-ticket"></i>
                                </div>
                                <div class="ps-3">
                                    <h4>

                                        <form action="/servicedesk/chamados/consultar_chamados.php" method="POST">

                                            <input type="hidden" name="atendentePesquisa" value="%">
                                            <input type="hidden" name="statusChamado" value="!= 3">

                                            <button type="submit" style=" background: none; border: none; cursor: pointer;">
                                                <?= $quantidade_chamados_abertos ?>
                                                <?php
                                                if ($quantidade_chamados_abertos < 2) {
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
                    <div class="card info-card revenue-card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Chamados sem atendente</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-ticket-perforated"></i>
                                </div>
                                <div class="ps-3">
                                    <h4>
                                        <form action="/servicedesk/chamados/consultar_chamados.php" method="POST">

                                            <input type="hidden" name="atendentePesquisa" value="0">
                                            <input type="hidden" name="statusChamado" value="!= 3">

                                            <button type="submit" style=" background: none; border: none; cursor: pointer;">
                                                <?= $quantidade_chamados_sem_atendente ?>
                                                <?php
                                                if ($quantidade_chamados_sem_atendente < 2) {
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
                    <div class="card info-card customers-card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Meus chamados</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-ticket-detailed"></i>
                                </div>
                                <div class="ps-3">
                                    <h4>
                                        <form action="/servicedesk/chamados/consultar_chamados.php" method="POST">
                                            <input type="hidden" name="atendentePesquisa" value="<?= $_SESSION['id'] ?>">
                                            <input type="hidden" name="statusChamado" value="!= 3">

                                            <button type="submit" style=" background: none; border: none; cursor: pointer;">
                                                <?= $quantidade_meus_chamados ?>
                                                <?php
                                                if ($quantidade_meus_chamados < 2) {
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
                <div class="col-xxl-3 col-md-3">
                    <div class="card info-card customers-card text-center">
                        <div class="card-body">
                            <h4 class="card-title">Manutenção Programada</h4>
                            <div class="d-flex align-items-center">

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
                        <?php } ?>

                        <?php
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
                                                <i class="bi bi-ticket"></i>
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
        </div>
    </div>
    <div class="col-lg-12">

        <div class="row">
            <div class="col-lg-4">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">POPs Atividades (Limitado a 20 resultados)</h5>
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
                                DATE_FORMAT(pap.date, '%d %m %Y') as data_programada
                                FROM 
                                    pop_atividade_programada as pap
                                LEFT JOIN
                                    pop as p
                                ON
                                    p.id = pap.pop_id
                                WHERE
                                    pap.status = 1
                                ORDER BY pap.date ASC
                                LIMIT 20");

                                    // Executa a consulta
                                    $stmt->execute();

                                    // Obtém os resultados da consulta
                                    $atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Exibe os resultados na tabela
                                    foreach ($atividades as $atividade) {
                                        echo '<tr>';

                                        echo '<td>' . $atividade['pop'] . '</td>';
                                        echo '<td>' . $atividade['atividade'] . '</td>';
                                        echo '<td>' . $atividade['data_programada'] . '</td>';
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
            </div>

            <div class="col-lg-4">
                <?php if ($permite_interagir_chamados != 0) { ?>
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Últimos chamados (Limitado a 20 resultados)</h5>
                            <table class="table table-striped" id="styleTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Número</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Chamado</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($campos_ultimos_30_chamados = $r_ultimos_30_chamados->fetch_array()) { ?>
                                        <tr onclick="location.href='/servicedesk/chamados/visualizar_chamado.php?id=<?= $campos_ultimos_30_chamados['idChamado'] ?>'">
                                            <td><?= $campos_ultimos_30_chamados['idChamado'] ?></th>
                                            <td><?= $campos_ultimos_30_chamados['fantasia'] ?></td>
                                            <td><?= $campos_ultimos_30_chamados['assuntoChamado'] ?></td>
                                            <td><span style="background-color: <?= $campos_ultimos_30_chamados['statusColor'] ?>;" class="badge"><?= $campos_ultimos_30_chamados['status_chamado'] ?></span></td>
                                        </tr>
                                    <?php
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>


        </div>
    </div>
</section>