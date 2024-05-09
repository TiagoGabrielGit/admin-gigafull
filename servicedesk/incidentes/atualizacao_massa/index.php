<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";
require "../../../conexoes/conexao.php";

$submenu_id = "33";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
?>


    <main id="main" class="main">
        <section class="section">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Atualização em Massa</h5>
                        <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-4">
                                    <label for="tipo" class="form-label">Tipo Informativo</label>
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option selected disabled value="">Selecione...</option>
                                        <?php
                                        $sql = "SELECT * FROM incidentes_types as it where it.active = 1 ORDER BY it.type ASC";
                                        $result = $mysqli->query($sql);
                                        while ($row = $result->fetch_assoc()) { ?>

                                            <option value="<?= $row['codigo'] ?>" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == $row['codigo']) echo "selected"; ?>><?= $row['type'] ?></option>

                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <div style="margin-top: 35px;" class="col-4">
                                    <button type="submit" class="btn btn-sm btn-danger">Selecionar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $tipo_incidente = $_POST['tipo'];
                if ($tipo_incidente == 100) { ?>
                    <form method="POST" action="processa/atualizar_gpon.php" class="row g-3">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Selecione os incidentes</h5>
                                    <?php
                                    $incidentes_gpon =
                                        "SELECT i.id as id, i.descricaoIncidente, ic.classificacao, date_format(i.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao, i.descricaoEvento as descricaoEvento
                                            FROM incidentes as i
                                            LEFT JOIN incidentes_classificacao as ic ON ic.id = i.classificacao 
                                            WHERE i.active = 1 AND i.incident_type = 100";

                                    $stmt_gpon = $pdo->prepare($incidentes_gpon);
                                    $stmt_gpon->execute();
                                    ?>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button id="marcarTodos" type="button" class="btn btn-sm btn-outline-primary">Marcar</button>
                                                        <button id="desmarcarTodos" type="button" class="btn btn-sm btn-outline-primary">Desmarcar</button>
                                                    </div>
                                                </th>
                                                <th style="text-align: center;">Evento</th>
                                                <th style="text-align: center;">Descrição Evento</th>
                                                <th style="text-align: center;">Classificação</th>
                                                <th style="text-align: center;">Previsão de Normalização</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($stmt_gpon->rowCount() > 0) {
                                                while ($row_gpon = $stmt_gpon->fetch(PDO::FETCH_ASSOC)) {
                                                    if ($row_gpon['previsaoNormalizacao'] === null) {
                                                        $previsaoNormalizacao = "Sem Previsão";
                                                    } else {
                                                        $previsaoNormalizacao = $row_gpon['previsaoNormalizacao'];
                                                    }
                                            ?>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <input type="checkbox" name="checkboxes[]" value="<?= $row_gpon['id'] ?>">
                                                        </td>
                                                        <td style="text-align: center;"><?= $row_gpon['descricaoIncidente'] ?></td>
                                                        <td style="text-align: center;">
                                                            <?= $row_gpon['descricaoEvento'] !== null ? nl2br($row_gpon['descricaoEvento']) : '' ?>

                                                        </td>
                                                        <td style="text-align: center;"><?= $row_gpon['classificacao'] ?></td>
                                                        <td style="text-align: center;"><?= $previsaoNormalizacao ?></td>

                                                    </tr>
                                            <?php }
                                            } else {
                                                echo "Não foram encontrados incidentes ativos.";
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Atualizar Informativo</h5>

                                    <input hidden readonly id="solicitante" name="solicitante" value="<?= $uid ?>"></input>

                                    <div class="row">
                                        <div class="col-9">
                                            <label for="descEvento" class="form-label">Descrição do Evento</label>
                                            <input id="descEvento" name="descEvento" class="form-control"></input>
                                        </div>
                                        <div class="col-3">
                                            <label for="protocoloERP" class="form-label">Protocolo ERP</label>
                                            <input type="number" id="protocoloERP" name="protocoloERP" class="form-control"></input>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="col-12">
                                                <label for="classIncidente" class="form-label">Classificação</label>
                                                <select id="classIncidente" name="classIncidente" class="form-select" required>
                                                    <option disabled selected value="">Selecione</option>
                                                    <?php
                                                    $sql_classificacao =
                                                        "SELECT ic.id as idClassificacao, ic.classificacao as classificacao
                                                            FROM incidentes_classificacao as ic
                                                            WHERE ic.active = 1
                                                            ORDER BY ic.classificacao ASC";

                                                    $r_classificacao = mysqli_query($mysqli, $sql_classificacao);
                                                    while ($c_classificacao = mysqli_fetch_object($r_classificacao)) :
                                                        echo "<option value='$c_classificacao->idClassificacao'> $c_classificacao->classificacao</option>";
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="col-12">
                                                <label for="statusIncidente" class="form-label">Status</label>
                                                <select id="statusIncidente" name="statusIncidente" class="form-select" required>
                                                    <option disabled selected value="">Selecione</option>
                                                    <option value="1">Aberto</option>
                                                    <option value="0">Fechado</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label for="previsaoConclusao" class="form-label">Previsão de Conclusão</label>
                                            <input name="previsaoConclusao" type="datetime-local" class="form-control" id="previsaoConclusao">
                                        </div>


                                        <div class="col-2 d-flex flex-column align-items-center">
                                            <div>
                                                <label for="semPrevisao" class="form-label">Sem Previsão</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="semPrevisao" name="semPrevisao">
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="col-12">
                                        <label for="relatoIncidente" class="form-label">Relato</label>
                                        <textarea id="relatoIncidente" name="relatoIncidente" class="form-control" maxlength="500" rows="5" required></textarea>
                                    </div>

                                    <hr class="sidebar-divider">

                                    <div class="col-4"></div>
                                    <div class="col-4" style="text-align: center;">
                                        <button class="btn btn-sm btn-danger" type="submit">Atualizar</button>
                                    </div>
                                    <div class="col-4"></div>
                                </div>
                            </div>
                        </div>

                    </form>
                <?php } else if ($tipo_incidente == 102) { ?>
                    <form method="POST" action="processa/atualizar_backbone.php" class="row g-3">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Selecione os incidentes</h5>
                                    <?php
                                    $incidentes_backbone =
                                        "SELECT i.id as id, i.descricaoIncidente, ic.classificacao, date_format(i.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao,
                                         rf.ponta_a as ponta_a, rf.ponta_b as ponta_b, i.descricaoEvento
                                               FROM incidentes as i
                                               LEFT JOIN incidentes_classificacao as ic ON ic.id = i.classificacao 
                                               INNER JOIN rotas_fibra as rf ON i.equipamento_id = rf.codigo
                                               WHERE i.active = 1 AND i.incident_type = 102";

                                    $stmt_backbone = $pdo->prepare($incidentes_backbone);
                                    $stmt_backbone->execute();
                                    ?>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button id="marcarTodos" type="button" class="btn btn-sm btn-outline-primary">Marcar</button>
                                                        <button id="desmarcarTodos" type="button" class="btn btn-sm btn-outline-primary">Desmarcar</button>
                                                    </div>
                                                </th>
                                                <th style="text-align: center;">Rota</th>
                                                <th style="text-align: center;">Descrição Evento</th>
                                                <th style="text-align: center;">Classificação</th>
                                                <th style="text-align: center;">Previsão de Normalização</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($stmt_backbone->rowCount() > 0) {
                                                while ($row_backbone = $stmt_backbone->fetch(PDO::FETCH_ASSOC)) {
                                                    if ($row_backbone['previsaoNormalizacao'] === null) {
                                                        $previsaoNormalizacao = "Sem Previsão";
                                                    } else {
                                                        $previsaoNormalizacao = $row_backbone['previsaoNormalizacao'];
                                                    }
                                            ?>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <input type="checkbox" name="checkboxes[]" value="<?= $row_backbone['id'] ?>">
                                                        </td>
                                                        <td style="text-align: center;"><?= "ROTA: " . $row_backbone['ponta_a'] . " <> " . $row_backbone['ponta_b']; ?></td>
                                                        <td style="text-align: center;">
                                                            <?= $row_backbone['descricaoEvento'] !== null ? nl2br($row_backbone['descricaoEvento']) : '' ?>

                                                        </td>
                                                        <td style="text-align: center;"><?= $row_backbone['classificacao'] ?></td>
                                                        <td style="text-align: center;"><?= $previsaoNormalizacao ?></td>

                                                    </tr>
                                            <?php }
                                            } else {
                                                echo "Não foram encontrados incidentes ativos.";
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Atualizar Incidentes</h5>

                                    <input hidden readonly id="solicitante" name="solicitante" value="<?= $uid ?>"></input>

                                    <div class="row">
                                        <div class="col-9">
                                            <label for="descEvento" class="form-label">Descrição do Evento</label>
                                            <input id="descEvento" name="descEvento" class="form-control"></input>
                                        </div>
                                        <div class="col-3">
                                            <label for="protocoloERP" class="form-label">Protocolo ERP</label>
                                            <input type="number" id="protocoloERP" name="protocoloERP" class="form-control"></input>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="col-12">
                                                <label for="classIncidente" class="form-label">Classificação</label>
                                                <select id="classIncidente" name="classIncidente" class="form-select" required>
                                                    <option disabled selected value="">Selecione</option>
                                                    <?php
                                                    $sql_classificacao =
                                                        "SELECT ic.id as idClassificacao, ic.classificacao as classificacao
                                                               FROM incidentes_classificacao as ic
                                                               WHERE ic.active = 1
                                                               ORDER BY ic.classificacao ASC";

                                                    $r_classificacao = mysqli_query($mysqli, $sql_classificacao);
                                                    while ($c_classificacao = mysqli_fetch_object($r_classificacao)) :
                                                        echo "<option value='$c_classificacao->idClassificacao'> $c_classificacao->classificacao</option>";
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="col-12">
                                                <label for="statusIncidente" class="form-label">Status</label>
                                                <select id="statusIncidente" name="statusIncidente" class="form-select" required>
                                                    <option disabled selected value="">Selecione</option>
                                                    <option value="1">Aberto</option>
                                                    <option value="0">Fechado</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label for="previsaoConclusao" class="form-label">Previsão de Conclusão</label>
                                            <input name="previsaoConclusao" type="datetime-local" class="form-control" id="previsaoConclusao">
                                        </div>


                                        <div class="col-2 d-flex flex-column align-items-center">
                                            <div>
                                                <label for="semPrevisao" class="form-label">Sem Previsão</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="semPrevisao" name="semPrevisao">
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="col-12">
                                        <label for="relatoIncidente" class="form-label">Relato</label>
                                        <textarea id="relatoIncidente" name="relatoIncidente" class="form-control" maxlength="500" rows="5" required></textarea>
                                    </div>

                                    <hr class="sidebar-divider">

                                    <div class="col-4"></div>
                                    <div class="col-4" style="text-align: center;">
                                        <button class="btn btn-sm btn-danger" type="submit">Atualizar</button>
                                    </div>
                                    <div class="col-4"></div>
                                </div>
                            </div>
                        </div>

                    </form>
                <?php } else { ?>
                    <form method="POST" action="processa/atualizar_outros.php" class="row g-3">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Selecione os informativos</h5>
                                    <?php
                                    $incidentes_outros =
                                        "SELECT i.id as id, i.descricaoIncidente, ic.classificacao, date_format(i.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao, i.descricaoEvento as descricaoEvento
                                               FROM incidentes as i
                                               LEFT JOIN incidentes_classificacao as ic ON ic.id = i.classificacao 
                                               WHERE i.active = 1 AND i.incident_type = $tipo_incidente";

                                    $stmt_outros = $pdo->prepare($incidentes_outros);
                                    $stmt_outros->execute();
                                    ?>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button id="marcarTodos" type="button" class="btn btn-sm btn-outline-primary">Marcar</button>
                                                        <button id="desmarcarTodos" type="button" class="btn btn-sm btn-outline-primary">Desmarcar</button>
                                                    </div>
                                                </th>
                                                <th style="text-align: center;">Evento</th>
                                                <th style="text-align: center;">Descrição Evento</th>
                                                <th style="text-align: center;">Classificação</th>
                                                <th style="text-align: center;">Previsão de Normalização</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($stmt_outros->rowCount() > 0) {
                                                while ($row_outros = $stmt_outros->fetch(PDO::FETCH_ASSOC)) {
                                                    if ($row_outros['previsaoNormalizacao'] === null) {
                                                        $previsaoNormalizacao = "Sem Previsão";
                                                    } else {
                                                        $previsaoNormalizacao = $row_outros['previsaoNormalizacao'];
                                                    }
                                            ?>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <input type="checkbox" name="checkboxes[]" value="<?= $row_outros['id'] ?>">
                                                        </td>
                                                        <td style="text-align: center;"><?= $row_outros['descricaoIncidente'] ?></td>
                                                        <td style="text-align: center;">
                                                            <?= $row_outros['descricaoEvento'] !== null ? nl2br($row_outros['descricaoEvento']) : '' ?>
                                                        </td>
                                                        <td style="text-align: center;"><?= $row_outros['classificacao'] ?></td>
                                                        <td style="text-align: center;"><?= $previsaoNormalizacao ?></td>

                                                    </tr>
                                            <?php }
                                            } else {
                                                echo "Não foram encontrados incidentes ativos.";
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Atualizar Incidentes</h5>

                                    <input hidden readonly id="solicitante" name="solicitante" value="<?= $uid ?>"></input>

                                    <div class="row">
                                        <div class="col-9">
                                            <label for="descEvento" class="form-label">Descrição do Evento</label>
                                            <textarea rows="3" style="resize: none;" id="descEvento" name="descEvento" class="form-control"></textarea>
                                        </div>
                                        <div class="col-3">
                                            <label for="protocoloERP" class="form-label">Protocolo ERP</label>
                                            <input type="number" id="protocoloERP" name="protocoloERP" class="form-control"></input>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="col-12">
                                                <label for="classIncidente" class="form-label">Classificação</label>
                                                <select id="classIncidente" name="classIncidente" class="form-select" required>
                                                    <option disabled selected value="">Selecione</option>
                                                    <?php
                                                    $sql_classificacao =
                                                        "SELECT ic.id as idClassificacao, ic.classificacao as classificacao
                                                               FROM incidentes_classificacao as ic
                                                               WHERE ic.active = 1
                                                               ORDER BY ic.classificacao ASC";

                                                    $r_classificacao = mysqli_query($mysqli, $sql_classificacao);
                                                    while ($c_classificacao = mysqli_fetch_object($r_classificacao)) :
                                                        echo "<option value='$c_classificacao->idClassificacao'> $c_classificacao->classificacao</option>";
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="col-12">
                                                <label for="statusIncidente" class="form-label">Status</label>
                                                <select id="statusIncidente" name="statusIncidente" class="form-select" required>
                                                    <option disabled selected value="">Selecione</option>
                                                    <option value="1">Aberto</option>
                                                    <option value="0">Fechado</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label for="previsaoConclusao" class="form-label">Previsão de Conclusão</label>
                                            <input name="previsaoConclusao" type="datetime-local" class="form-control" id="previsaoConclusao">
                                        </div>


                                        <div class="col-2 d-flex flex-column align-items-center">
                                            <div>
                                                <label for="semPrevisao" class="form-label">Sem Previsão</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="semPrevisao" name="semPrevisao">
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="col-12">
                                        <label for="relatoIncidente" class="form-label">Relato</label>
                                        <textarea id="relatoIncidente" name="relatoIncidente" class="form-control" maxlength="500" rows="5" required></textarea>
                                    </div>

                                    <hr class="sidebar-divider">


                                    <div class="text-center">
                                        <button class="btn btn-sm btn-danger" type="submit">Atualizar Informativo</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>

            <?php }
            } ?>


        </section>
    </main>

    <script>
        document.getElementById("marcarTodos").addEventListener("click", function() {
            marcarDesmarcarCheckboxes(true);
        });

        document.getElementById("desmarcarTodos").addEventListener("click", function() {
            marcarDesmarcarCheckboxes(false);
        });

        function marcarDesmarcarCheckboxes(marcar) {
            var checkboxes = document.getElementsByName("checkboxes[]");
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = marcar;
            });
        }
    </script>


<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>