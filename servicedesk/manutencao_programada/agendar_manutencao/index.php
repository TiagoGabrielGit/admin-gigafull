<?php
require "../../../includes/menu.php";
require "../../../includes/remove_setas_number.php";
require "../../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];
$submenu_id = "35";

$permissions =
    "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
?>
    <main id="main" class="main">

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Manutenção Programada</h3>

                            <hr class="sidebar-divider">

                            <br><br>

                            <form method="POST" action="processa/criar_manutencao_programada.php" class="row g-3">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="titulo" class="form-label">Titulo</label>
                                        <input name="titulo" type="text" class="form-control" id="titulo" required>
                                    </div>

                                    <div class="col-3">
                                        <label for="dataAgendamento" class="form-label">Data Agendamento</label>
                                        <input name="dataAgendamento" type="datetime-local" class="form-control" id="dataAgendamento" required>
                                    </div>

                                    <div class="col-2">
                                        <label for="duracao" class="form-label">Duração (em horas)</label>
                                        <input name="duracao" type="number" class="form-control" id="duracao" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea id="descricao" name="descricao" class="form-control" style="height: 100px"></textarea>
                                    </div>

                                    <div class="col-6">
                                        <label for="mensagem" class="form-label">Mensagem</label>
                                        <textarea id="mensagem" name="mensagem" class="form-control" style="height: 100px"></textarea>
                                    </div>
                                </div>
                                <hr class="sidebar-divider">

                                <li class="nav-heading" style="list-style: none;"><b>Pontos Afetados</b></li>

                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Rotas de Fibra</h5>
                                                <ul>
                                                    <?php
                                                    $query = "SELECT
                                                rf.id as id,
                                                rf.ponta_a as ponta_a,
                                                rf.ponta_b as ponta_b
                                                FROM
                                                rotas_fibra as rf
                                                WHERE
                                                rf.active = 1";

                                                    try {
                                                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                        $stmt = $pdo->prepare($query);
                                                        $stmt->execute();
                                                        $rotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    } catch (PDOException $e) {
                                                        echo "Erro na consulta SQL: " . $e->getMessage();
                                                    }

                                                    foreach ($rotas as $rota) :
                                                    ?>
                                                        <li>
                                                            <label class="form-check-label">
                                                                <input value="<?= $rota['id'] ?> class=" form-check-input me-1" name="rotasDeFibra[]" type="checkbox">
                                                                <?= $rota['ponta_a'] . " <b> <> </b> " . $rota['ponta_b']; ?>
                                                            </label>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">GPON</h5>

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
                                    </div>

                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-danger">Agendar Manutenção</button>
                                </div>
                            </form><!-- Vertical Form -->

                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->
<?php

} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>