<hr class="sidebar-divider">

<div class="accordion" id="accordionFlushExample">

    <?php
    $manutencao_programada =
        "SELECT
mp.id as idMP,
mp.titulo as titulo,
mp.descricao as descricao,
mp.duracao as duracao,
DATE_FORMAT(mp.dataAgendamento, '%d/%m/%Y %H:%i') as dataAgendamento
FROM manutencao_programada as mp
WHERE mp.active = 1
order by mp.dataAgendamento asc
";

    $r_manutencao_programada = mysqli_query($mysqli, $manutencao_programada);

    $contador = 1;
    while ($c_manutencao_programada = $r_manutencao_programada->fetch_array()) {
        $idManutencao = $c_manutencao_programada['idMP'];

        $check_interessados_gpon =
            "SELECT COUNT(*) as qtde
            FROM manutencao_gpon as mg
            LEFT JOIN gpon_pon as gp ON mg.pon_id = gp.id
            LEFT JOIN gpon_olts as go ON go.id = gp.olt_id
            LEFT JOIN gpon_olts_interessados as goi ON go.id = goi.gpon_olt_id
            WHERE mg.manutencao_id = $idManutencao and goi.interessado_empresa_id = $empresaID and goi.active = 1";
        $result_gpon = $mysqli->query($check_interessados_gpon);
        $row_gpon = $result_gpon->fetch_assoc();
        $qtde_interessados_gpon = $row_gpon['qtde'];

        $check_interessados_backbone =
            "SELECT COUNT(*) as qtde
            FROM manutencao_rotas_fibra as mrf
            LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = mrf.rota_id
            WHERE mrf.manutencao_id = $idManutencao and rfi.interessado_empresa_id = $empresaID and rfi.active = 1";
        $result_backbone = $mysqli->query($check_interessados_backbone);
        $row_backbone = $result_backbone->fetch_assoc();
        $qtde_interessados_backbone = $row_backbone['qtde'];

        if ($qtde_interessados_backbone > 0 || $qtde_interessados_gpon > 0) {

            $titulo = $c_manutencao_programada['titulo'];
            $descricao = $c_manutencao_programada['descricao'];
            $duracao = $c_manutencao_programada['duracao'];
            $dataAgendamento = $c_manutencao_programada['dataAgendamento'];

    ?>

            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingMP<?= $contador ?>">
                    <button class="accordion-button collapsed" id="styleTableIncidentesAlarm" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseMP<?= $contador ?>" aria-expanded="false" aria-controls="flush-collapseMP<?= $contador ?>">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span class="text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" stroke="black" fill="black" class="bi bi-flag-fill" viewBox="0 0 16 16">
                                    <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"></path>
                                </svg>
                                &nbsp; &nbsp;<b>
                                    <?php
                                    $titulo = strtoupper($titulo);
                                    $titulo = mb_strtoupper($titulo, 'utf-8');
                                    echo $titulo;
                                    ?>

                                </b> <br>
                                &nbsp; &nbsp; &nbsp; &nbsp; <?= $descricao ?>
                                <br><br>
                                <b>&nbsp; &nbsp; &nbsp; &nbsp;Data Agendamento: </b><?= $dataAgendamento ?>
                                <b>&nbsp; &nbsp; &nbsp; &nbsp;Tempo Estimado: </b><?= $duracao ?> hora/s

                            </span>
                            <span class="text-end">


                            </span>
                        </div>
                    </button>

                </h2>
                <div id="flush-collapseMP<?= $contador ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingMP<?= $contador ?>" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body colorAccordion">
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Rotas de Fibra</h5>
                                        <ul>
                                            <?php
                                            $rotas = "SELECT
                                                mrf.id as idMan,
                                                rf.ponta_a as ponta_a,
                                                rf.ponta_b as ponta_b
                                                FROM manutencao_rotas_fibra as mrf
                                                LEFT JOIN rotas_fibra as rf ON rf.id = mrf.rota_id
                                                LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = mrf.rota_id
                                                WHERE mrf.manutencao_id = $idManutencao and rfi.interessado_empresa_id = $empresaID and rfi.active = 1";
                                            try {
                                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $stmt = $pdo->prepare($rotas);
                                                $stmt->execute();
                                                $c_rotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            } catch (PDOException $e) {
                                                echo "Erro na consulta SQL: " . $e->getMessage();
                                            }

                                            foreach ($c_rotas as $rota) :
                                            ?>
                                                <li>
                                                    <label class="form-check-label">
                                                        <?= $rota['ponta_a'] . " <> " .  $rota['ponta_b']  ?>
                                                    </label>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">GPON</h5>
                                        <ul>
                                            <?php
                                            $gpon = "SELECT
                                                mg.id as idMan,
                                                gp.slot as slot,
                                                gp.pon as pon,
                                                gp.id as ponID,
                                                gpo.olt_name as olt_name
                                                FROM manutencao_gpon as mg
                                                LEFT JOIN gpon_pon as gp ON gp.id = mg.pon_id
                                                LEFT JOIN gpon_olts as gpo ON gpo.id = gp.olt_id
                                                LEFT JOIN gpon_olts_interessados as goi ON gpo.id = goi.gpon_olt_id
                                                WHERE mg.manutencao_id = $idManutencao and goi.interessado_empresa_id = $empresaID and goi.active = 1";

                                            try {
                                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                $stmt = $pdo->prepare($gpon);
                                                $stmt->execute();
                                                $pons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            } catch (PDOException $e) {
                                                echo "Erro na consulta SQL: " . $e->getMessage();
                                            }

                                            foreach ($pons as $pon) :
                                                $idPONManutencao = $pon['ponID'];
                                            ?>
                                                <li>
                                                    <label class="form-label">
                                                        <?= "OLT " . $pon['olt_name'] . " (SLOT " . $pon['slot'] . " | PON " .  $pon['pon'] . ")" ?>
                                                    </label>

                                                    <button title="Localidades" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalLocalidadesMP<?= $idPONManutencao ?>"><i class="bi bi-pin-map"></i></button>
                                                    <div class="modal fade" id="modalLocalidadesMP<?= $idPONManutencao ?>" tabindex="-1">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Localidades</h5>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="card-body">
                                                                        <div class="col-12">
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th style="text-align: center;">Cidade</th>
                                                                                        <th style="text-align: center;">Bairro</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $localidades_query = "SELECT cidade, bairro FROM gpon_localidades WHERE pon_id = :pon_id AND active = 1";
                                                                                    $stmt_localidades = $pdo->prepare($localidades_query);
                                                                                    $stmt_localidades->bindParam(':pon_id', $idPONManutencao);
                                                                                    $stmt_localidades->execute();

                                                                                    if ($stmt_localidades->rowCount() > 0) {
                                                                                        while ($row = $stmt_localidades->fetch(PDO::FETCH_ASSOC)) {
                                                                                            echo '<tr>';
                                                                                            echo '<td style="text-align: center;">' . $row['cidade'] . '</td>';
                                                                                            echo '<td style="text-align: center;">' . $row['bairro'] . '</td>';
                                                                                            echo '</tr>';
                                                                                        }
                                                                                    } else {
                                                                                        echo '<tr><td colspan="2" style="text-align: center;">Nenhuma localidade encontrada.</td></tr>';
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php $contador++;
        }
    } ?>
</div>