<h3 class="card-title">GPON Afetados</h3>

<form method="POST" action="processa/step2.php" class="row g-3">

    <hr class="sidebar-divider">
    <div class="row">
        <div class="col-lg-12">

            <div class="accordion" id="accordionExample">
                <?php
                $contador = "1";
                $query_olts =
                    "SELECT
                                                    gpo.id as idOLT,
                                                    gpo.olt_name as olt
                                                    FROM
                                                    gpon_olts as gpo
                                                    WHERE
                                                    gpo.active = 1
                                                    ORDER BY
                                                    gpo.olt_name ASC
                                                    ";
                $r_query_olts = mysqli_query($mysqli, $query_olts);
                while ($C_olts = $r_query_olts->fetch_array()) {
                    $idsOLTs = $C_olts['idOLT'];
                ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $contador ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $contador ?>" aria-expanded="false" aria-controls="collapse<?= $contador ?>">
                                <?= $C_olts['olt']; ?>
                            </button>
                        </h2>
                        <div id="collapse<?= $contador ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $contador ?>" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body">

                                <ul>
                                    <?php
                                    $query_pons = "SELECT
                                                                        gpp.id as id,
                                                                        gpp.slot as slot,
                                                                        gpp.pon as pon
                                                                        FROM
                                                                        gpon_pon as gpp
                                                                        WHERE
                                                                        gpp.active = 1
                                                                        and
                                                                        olt_id = $idsOLTs
                                                                        ORDER BY
                                                                        gpp.slot ASC,
                                                                        gpp.pon ASC";

                                    try {
                                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $stmt = $pdo->prepare($query_pons);
                                        $stmt->execute();
                                        $pons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    } catch (PDOException $e) {
                                        echo "Erro na consulta SQL: " . $e->getMessage();
                                    }

                                    foreach ($pons as $pon) :
                                    ?>
                                        <li>
                                            <label class="form-check-label">
                                                <input value="<?= $pon['id'] ?>" class="form-check-input me-1" name="pons[]" type="checkbox">
                                                <?= "SLOT " . $pon['slot'] . " - PON " . $pon['pon']; ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                <?php
                    $contador++;
                } ?>
                <input name="qtdeEquipamentos" id="qtdeEquipamentos" value="<?= $contador  ?>" hidden>
            </div><!-- End Default Accordion Example -->
        </div>

    </div>
    <hr class="sidebar-divider">
    <br><br>
    <div class="container">
        <input readonly hidden id="idMP" name="idMP" value="<?= $idMP ?>" />
        <div class="row">
            <div class="col-4">
                <button name="acao" value="salvar_rascunho" class="btn btn-sm btn-primary">Salvar Rascunho</button>
            </div>
            <div class="col-4">
                <button name="acao" value="avancar" class="btn btn-sm btn-danger">Avançar</button>
            </div>
            <div class="col-4">
                <button name="acao" value="cancelar_agendamento" class="btn btn-sm btn-secondary">Cancelar Agendamento</button>
            </div>
        </div>
    </div>
</form><!-- Vertical Form -->