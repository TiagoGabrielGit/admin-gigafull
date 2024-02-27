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

                                        <form action="/servicedesk/consultar_chamados/index.php" method="POST">

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
                                        <form action="/servicedesk/consultar_chamados/index.php" method="POST">

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
                                        <form action="/servicedesk/consultar_chamados/index.php" method="POST">
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
                                    <h5 class="card-title">Diretório Uploads (Max: 10Gb)</h5>
                                    <h1>
                                        <?php
                                        $folderPath = 'uploads/';

                                        // Calcula o tamanho ocupado pela pasta em bytes
                                        $totalSize = 0;

                                        $dirIterator = new RecursiveDirectoryIterator($folderPath);
                                        $iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);

                                        foreach ($iterator as $file) {
                                            if ($file->isFile()) {
                                                $totalSize += $file->getSize();
                                            }
                                        }

                                        // Converte para megabytes (MB) e arredonda para o valor mais próximo
                                        $usedSpaceMB = round($totalSize / (1024 * 1024));

                                        echo "{$usedSpaceMB}MB";
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">

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

            <div class="col-lg-5">
                <?php if ($permite_interagir_chamados != 0) { ?>
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Últimos 15 chamados</h5>
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
                                        <tr onclick="location.href='/servicedesk/consultar_chamados/view.php?id=<?= $campos_ultimos_30_chamados['idChamado'] ?>'">
                                            <td><?= $campos_ultimos_30_chamados['idChamado'] ?></th>
                                            <td><?= $campos_ultimos_30_chamados['fantasia'] ?></td>
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
                <?php } ?>

                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">POPs Atividades </h5>
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
                                LIMIT 15");

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
        </div>
    </div>
</section>