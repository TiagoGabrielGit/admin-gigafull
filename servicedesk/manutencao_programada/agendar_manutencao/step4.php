<h3 class="card-title">Resumo da Manutenção</h3>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rotas de Fibra</h5>
                <ul>
                    <?php
                    $rotas = "SELECT
                    mrf.id as idMan,
                    rf.ponta_a as ponta_a,
                    rf.ponta_b as ponta_b
                    FROM
                    manutencao_rotas_fibra as mrf
                    LEFT JOIN
                    rotas_fibra as rf
                    ON rf.id = mrf.rota_id
                    WHERE
                    mrf.manutencao_id = $idMP";

                    try {
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $pdo->prepare($rotas);
                        $stmt->execute();
                        $c_rotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Erro na consulta SQL: " . $e->getMessage();
                    }

                    if (empty($c_rotas)) {
                        echo "Nenhuma rota de fibra selecionada.";
                    } else {
                        foreach ($c_rotas as $rota) :
                    ?>
                            <li>
                                <label class="form-check-label">
                                    <?= $rota['ponta_a'] . " <> " .  $rota['ponta_b']  ?>
                                </label>
                            </li>
                    <?php endforeach;
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">GPON</h5>
                <ul>
                    <?php
                    $gpon = "SELECT
                    mg.id as idMan,
                    gp.slot as slot,
                    gp.pon as pon,
                    gpo.olt_name as olt_name
                    FROM manutencao_gpon as mg
                    LEFT JOIN gpon_pon as gp ON gp.id = mg.pon_id
                    LEFT JOIN gpon_olts as gpo ON gpo.id = gp.olt_id
                    WHERE
                    mg.manutencao_id = $idMP";

                    try {
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $pdo->prepare($gpon);
                        $stmt->execute();
                        $pons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo "Erro na consulta SQL: " . $e->getMessage();
                    }

                    if (empty($pons)) {
                        echo "Nenhuma PON selecionada.";
                    } else {
                        foreach ($pons as $pon) :
                    ?>
                            <li>
                                <label class="form-check-label">
                                    <?= "OLT " . $pon['olt_name'] . " (SLOT " . $pon['slot'] . " | PON " .  $pon['pon'] . ")" ?>
                                </label>
                            </li>
                    <?php endforeach;
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <form method="POST" action="processa/step4.php">

        <input readonly hidden id="idMP" name="idMP" value="<?= $idMP ?>" />

        <div class="row">
            <div class="col-3">
                <button name="acao" value="salvar_rascunho" class="btn btn-sm btn-primary equal-width-btn">Salvar Rascunho</button>
            </div>

            <div class="col-3">
                <button name="acao" value="voltar" class="btn btn-sm btn-warning equal-width-btn">Voltar</button>
            </div>

            <div class="col-3">
                <button name="acao" value="agendar_manutencao" class="btn btn-sm btn-success equal-width-btn">Agendar Manutenção</button>
            </div>

            <div class="col-3">
                <button name="acao" value="cancelar_agendamento" class="btn btn-sm btn-secondary equal-width-btn">Cancelar Comunicação</button>
            </div>
        </div>
    </form>
</div>