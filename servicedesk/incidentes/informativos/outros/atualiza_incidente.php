<?php
require "../../../../includes/menu.php";
require "../../../../conexoes/conexao_pdo.php";
require "../../../../includes/remove_setas_number.php";

$submenu_id = "22";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    require "../../../../conexoes/conexao.php";

    $permissaoGerenciar = $_SESSION['permite_gerenciar_incidente'];
    if ($permissaoGerenciar == 1) {
        $idIncidente = $_POST['idIncidente'];
        $sql =
            "SELECT
        i.zabbix_event_id as zabbixID,
        i.descricaoIncidente as descricaoIncidente,
        i.protocolo_erp as protocoloERP,
        i.previsaoNormalizacao as prevNOR,
        i.active as statusID,
        i.classificacao as idClassificacao,
        i.incident_type as incident_type
        FROM incidentes as i
        WHERE i.id = :id";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':id', $idIncidente, PDO::PARAM_INT);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        $zabbixID = $resultado['zabbixID'];
        $descIncidente = $resultado['descricaoIncidente'];
        $protocoloERP = $resultado['protocoloERP'];
        $prevNOR = $resultado['prevNOR'];
        $statusID = $resultado['statusID'];
        $idClassificacaoAtual = $resultado['idClassificacao'];
        $idTypeIncidenteAtual = $resultado['incident_type'];

?>
        <main class="main" id="main">
            <div class="pagetitle">
                <h1>Atualização de Incidente</h1>
            </div>
            <section class="section">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                            <div class="text-left">
                                <h5 class="card-title">Incidente: <?= $idIncidente ?> </h5>
                            </div>
                            <div class="text-end">
                                <div class="text-end">
                                    <button class="btn btn-sm btn-danger" style="margin-top: 25px;" id="requestTokenButton" onclick="goBack()">Voltar à página anterior</button>

                                    <script>
                                        function goBack() {
                                            window.history.back();
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                        <br>
                        <form action="processa/update.php" method="POST" class="row g-3">

                            <input hidden readonly id="incidenteID" name="incidenteID" value="<?= $idIncidente ?>"></input>
                            <input hidden readonly id="solicitante" name="solicitante" value="<?= $uid ?>"></input>
                            <input hidden readonly id="zabbixEventID" name="zabbixEventID" value="<?= $zabbixID ?>"></input>

                            <div class="row">
                                <div class="col-9">
                                    <label for="descIncidente" class="form-label">Descrição</label>
                                    <input value="<?= $descIncidente ?>" id="descIncidente" name="descIncidente" class="form-control" required></input>
                                </div>
                                <div class="col-3">
                                    <label for="protocoloERP" class="form-label">Protocolo ERP</label>
                                    <input type="number" value="<?= $protocoloERP ?>" id="protocoloERP" name="protocoloERP" class="form-control"></input>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-5">
                                    <div class="col-12">
                                        <label for="classIncidente" class="form-label">Classificação</label>
                                        <select id="classIncidente" name="classIncidente" class="form-select" required>
                                            <option disabled value="">Selecione</option>
                                            <?php
                                            $sql_classificacao =
                                                "SELECT ic.id as idClassificacao, ic.classificacao as classificacao
                                                FROM incidentes_classificacao as ic
                                                WHERE ic.active = 1
                                                ORDER BY ic.classificacao ASC";

                                            $r_classificacao = mysqli_query($mysqli, $sql_classificacao);
                                            while ($c_classificacao = mysqli_fetch_object($r_classificacao)) :
                                                $selected = ($c_classificacao->idClassificacao == $idClassificacaoAtual) ? 'selected' : ''; // Verifica se a opção corresponde ao $tipoIncidente
                                                echo "<option value='$c_classificacao->idClassificacao' $selected> $c_classificacao->classificacao</option>";
                                            endwhile;
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <label for="tipoIncidente" class="form-label">Tipo de Incidente</label>
                                    <select id="tipoIncidente" name="tipoIncidente" class="form-select" required>
                                        <option disabled value="">Selecione</option>
                                        <?php
                                        $sql_tipos =
                                            "SELECT it.codigo as idCodigo, it.type as tipo
                                            FROM incidentes_types as it
                                            WHERE it.active = 1
                                            ORDER BY it.type ASC";

                                        $r_tipo = mysqli_query($mysqli, $sql_tipos);
                                        while ($c_tipo = mysqli_fetch_object($r_tipo)) :
                                            $selected = ($c_tipo->idCodigo == $idTypeIncidenteAtual) ? 'selected' : ''; // Verifica se a opção corresponde ao $tipoIncidente
                                            echo "<option value='$c_tipo->idCodigo' $selected> $c_tipo->tipo</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <div class="col-12">
                                        <label for="statusIncidente" class="form-label">Status</label>
                                        <select id="statusIncidente" name="statusIncidente" class="form-select" required>
                                            <option disabled value="">Selecione</option>
                                            <option value="1" <?php echo ($statusID == 1) ? 'selected' : ''; ?>>Aberto</option>
                                            <option value="0" <?php echo ($statusID == 0) ? 'selected' : ''; ?>>Fechado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="col-12">
                                        <label for="comunicarInteressados" class="form-label">Comunicar Interessados</label>
                                        <select id="comunicarInteressados" name="comunicarInteressados" class="form-select" required>
                                            <option disabled selected value="">Selecione</option>
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="previsaoConclusao" class="form-label">Previsão de Conclusão</label>
                                    <input name="previsaoConclusao" type="datetime-local" class="form-control" id="previsaoConclusao" value="<?php if ($prevNOR !== null) : echo date('Y-m-d\TH:i', strtotime($prevNOR));
                                                                                                                                                endif;  ?>">
                                </div>


                                <div class="col-3 d-flex flex-column align-items-center">
                                    <div>
                                        <label for="semPrevisao" class="form-label">Sem Previsão</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="semPrevisao" name="semPrevisao">
                                    </div>
                                </div>

                            </div>

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
                        </form><!-- End Horizontal Form -->
                    </div>
                </div>
            </section>
        </main>

<?php
    } else {
        require "../../../../acesso_negado.php";
        require "../../../../includes/securityfooter.php";
    }
} else {
    require "../../../../acesso_negado.php";
    require "../../../../includes/securityfooter.php";
}
require "../../../../includes/securityfooter.php";
?>