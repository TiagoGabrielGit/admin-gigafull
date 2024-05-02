<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
require "../../includes/remove_setas_number.php";

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
    require "../../conexoes/conexao.php";

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
        i.incident_type as incident_type,
        gp.cod_int as paintegration_code
        FROM incidentes as i
        LEFT JOIN gpon_pon as gp ON gp.id = i.pon_id 
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
        $paintegration_code = $resultado['paintegration_code'];


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
                            <?php
                            if ($idTypeIncidenteAtual == 100) { ?>
                                <div class="12">
                                    <hr class="sidebar-divider">
                                    <span><b>Selecione as caixas afetadas</b></span>
                                    <?php
                                    $consulta_caixas = "SELECT * FROM gpon_ctos as gc WHERE gc.paintegration_code = :paintegration_code ORDER BY title ASC";

                                    $stmt = $pdo->prepare($consulta_caixas);
                                    $stmt->bindValue(':paintegration_code', $paintegration_code);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                    // Consulta para obter os IDs das caixas afetadas com base no ID do incidente
                                    $consulta_caixas_relacionadas = "SELECT cto_id FROM incidentes_ctos WHERE incidente_id = :incidenteID";

                                    $stmt = $pdo->prepare($consulta_caixas_relacionadas);
                                    $stmt->bindParam(':incidenteID', $idIncidente, PDO::PARAM_INT);
                                    $stmt->execute();

                                    // Obtenha os IDs das caixas afetadas
                                    $caixas_relacionadas = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
                                    ?>

                                    <div class="row mb-3">
                                        <?php $count = 0; ?>
                                        <?php foreach ($result as $row) : ?>
                                            <?php if ($count % 4 === 0) : ?>
                                    </div>
                                    <div class="row mb-3">
                                    <?php endif; ?>

                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck<?= $row['id']; ?>" data-caixa-id="<?= $row['id'] ?>" <?= in_array($row['id'], $caixas_relacionadas) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="gridCheck<?= $row['id']; ?>">
                                                <?= $row['title']; ?>
                                            </label>
                                        </div>
                                    </div>


                                    <?php $count++; ?>
                                <?php endforeach; ?>
                                    </div>

                                    <hr class="sidebar-divider">
                                </div>
                            <?php } ?>

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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.form-check-input');

                checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('click', function() {
                        const incidenteID = <?= $idIncidente ?>;
                        const caixaID = this.getAttribute('data-caixa-id');

                        if (this.checked) {
                            // Checkbox marcado: enviar solicitação para adicionar
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', 'processa/adiciona_cto_afetada.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    // Verifique a resposta do servidor, se necessário
                                }
                            };
                            xhr.send('incidenteID=' + incidenteID + '&caixaID=' + caixaID);
                        } else {
                            // Checkbox desmarcado: enviar solicitação para remover
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', 'processa/remove_cto_afetada.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    // Verifique a resposta do servidor, se necessário
                                    const response = xhr.responseText;
                                    // Atualizar a interface do usuário se a exclusão foi bem-sucedida
                                    if (response === 'success') {
                                        // Atualize a interface do usuário conforme necessário
                                    }
                                }
                            };
                            xhr.send('incidenteID=' + incidenteID + '&caixaID=' + caixaID);
                        }
                    });
                });
            });
        </script>



        <script>
            function goBack() {
                window.history.back();
            }
        </script>
<?php
    } else {
        require "../../acesso_negado.php";
        require "../../includes/securityfooter.php";
    }
} else {
    require "../../acesso_negado.php";
    require "../../includes/securityfooter.php";
}
require "../../includes/securityfooter.php";
?>