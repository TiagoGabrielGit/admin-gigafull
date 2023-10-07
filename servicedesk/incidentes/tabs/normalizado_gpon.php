<hr class="sidebar-divider">

<?php
$classificacao_gpon = '%';
$comunicado_gpon = '%';
$limite = '15';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filterClassificacaoGPON'])) {
    $classificacao_gpon = $_POST['filterClassificacaoGPON'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filterComunicadoGPON'])) {
    $comunicado_gpon = $_POST['filterComunicadoGPON'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filterLimiteGPON'])) {
    $limite = $_POST['filterLimiteGPON'];
}
?>

<div class="col-lg-12">
    <form method="POST" action="#">
        <div class="row">
            <div class="col-4">
                <label for="filterClassificacaoGPON" class="form-label">Classificação</label>
                <select id="filterClassificacaoGPON" name="filterClassificacaoGPON" class="form-select">
                    <option value="%" <?php if (!isset($_POST['filterClassificacaoGPON']) || $_POST['filterClassificacaoGPON'] === '%') echo ' selected'; ?>>Todos</option>
                    <?php
                    try {
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql_classificacao =
                            "SELECT ic.id, ic.classificacao
                            FROM incidentes_classificacao as ic
                            WHERE ic.active = 1
                            ORDER BY ic.classificacao ASC";
                        $stmt = $pdo->prepare($sql_classificacao);
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $optionValue = $row['id'];
                            $optionText = $row['classificacao'];
                            $selected = (isset($_POST['filterClassificacaoGPON']) && $_POST['filterClassificacaoGPON'] == $optionValue) ? 'selected' : ''; // Verifica se esta opção deve ser selecionada
                    ?>
                            <option value="<?= $optionValue ?>" <?= $selected ?>><?= $optionText ?></option>
                    <?php
                        }
                    } catch (PDOException $e) {
                        echo "Erro na conexão: " . $e->getMessage();
                    }
                    ?>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label" for="filterComunicadoGPON">Comunicado Normalização</label>
                <select name="filterComunicadoGPON" class="form-select" id="filterComunicadoGPON">
                    <option value="%" <?php if ($comunicado_gpon == '%') echo "selected"; ?>>Todos</option>
                    <option value="0" <?php if ($comunicado_gpon == 0) echo "selected"; ?>>Não Enviado</option>
                    <option value="1" <?php if ($comunicado_gpon == 1) echo "selected"; ?>>Enviado</option>
                </select>
            </div>

            <div class="col-3">
                <label for="filterLimiteGPON" class="form-label"> Limite de Busca</label>
                <select id="filterLimiteGPON" name="filterLimiteGPON" class="form-select">
                    <option value="15" <?php if ($limite == 15) echo "selected"; ?>>15 Incidentes</option>
                    <option value="50" <?php if ($limite == 50) echo "selected"; ?>>50 Incidentes</option>
                    <option value="100" <?php if ($limite == 100) echo "selected"; ?>>100 Incidentes</option>


                </select>
            </div>
            <div class="col-2">
                <button style="margin-top:  35px;" type="submit" class="btn btn-sm btn-danger">Filtrar</button>
            </div>
        </div>
    </form>
</div>

<hr class="sidebar-divider">

<div class="accordion" id="accordionFlushExample">

    <?php

    $sql_incidentes =
        "SELECT
                i.zabbix_event_id as zabbixID,
                i.id as idIncidente,
                i.incident_type as incident_type,
                i.equipamento_id,
                i.descricaoIncidente as descricaoIncidente,
                i.active as activeID,
                ic.classificacao as classificacao,
                i.envio_com_normalizacao as envio_com_normalizacao,
                ic.color as ClassColor,
                i.pon_id as pon_id,
                i.previsaoNormalizacao as previsaoNormalizacao2,
                it.type as tipo,
                p.nome as criador,
                date_format(i.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao,
                date_format(i.inicioIncidente,'%H:%i:%s %d/%m/%Y') as horainicial,
                date_format(i.fimIncidente,'%H:%i:%s %d/%m/%Y') as horafinal,
                IF (i.fimIncidente IS NULL, TIMEDIFF(NOW(), i.inicioIncidente), TIMEDIFF(i.fimIncidente, i.inicioIncidente)) as tempoIncidente
                FROM incidentes i
                INNER JOIN gpon_olts o ON i.equipamento_id = o.equipamento_id
                INNER JOIN gpon_olts_interessados oi ON o.id = oi.gpon_olt_id
                LEFT JOIN incidentes_classificacao as ic ON ic.id = i.classificacao
                LEFT JOIN usuarios as u ON i.autor_id = u.id LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                LEFT JOIN incidentes_types as it ON it.codigo = i.incident_type
                WHERE oi.interessado_empresa_id = $empresaID AND i.active = 0 AND oi.active = 1 AND i.classificacao LIKE '$classificacao_gpon' AND i.envio_com_normalizacao LIKE '$comunicado_gpon'
                ORDER BY i.inicioIncidente DESC
                LIMIT $limite";


    $r_sql_incidentes = mysqli_query($mysqli, $sql_incidentes);

    $cont = 1;
    while ($campos = $r_sql_incidentes->fetch_array()) {
        $id_incidente = $campos['idIncidente'];
        $pon_id = $campos['pon_id'];

        $hostID = $campos['equipamento_id'];
        $sql_host =
            "SELECT
                    eqp.hostname as identificacao
                FROM
                    equipamentospop as eqp
                WHERE
                    eqp.id = $hostID
                ";

        $r_host = mysqli_query($mysqli, $sql_host);
        $c_host = $r_host->fetch_array();
        $identificacao = "EQUIPAMENTO: " . $c_host['identificacao'];

    ?>

        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading<?= $cont ?>">
                <button class="accordion-button collapsed" id="styleTableIncidentesOK" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span class="text-left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" stroke="black" fill="black" class="bi bi-flag-fill" viewBox="0 0 16 16">
                                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"></path>
                            </svg>
                            &nbsp; &nbsp;<b>
                                <?php
                                $identificacao = strtoupper($identificacao);
                                $identificacao = mb_strtoupper($identificacao, 'utf-8');
                                echo $identificacao;
                                ?>

                            </b> <br>
                            &nbsp; &nbsp; &nbsp; &nbsp; <?= $campos['descricaoIncidente'] ?>
                            <br><br>
                            <b>&nbsp; &nbsp; &nbsp; &nbsp;Tempo total incidente: </b><?= $campos['tempoIncidente']; ?>
                        </span>
                        <span class="text-end">

                            <?php
                            if ($campos['classificacao'] == NULL) { ?>
                                <span class="btn btn-sm rounded-pill mb-1" style="background-color: <?= $campos['ClassColor'] ?>"><b>Não Classificado</b></span>
                            <?php } else { ?>
                                <span class="btn btn-sm rounded-pill mb-1" style="background-color: <?= $campos['ClassColor'] ?>"><b><?= $campos['classificacao'] ?></b></span>
                            <?php } ?>

                            <?php
                            $currentDate = strtotime(date("Y-m-d H:i:s"));
                            $previsaoNormalizacao = strtotime($campos['previsaoNormalizacao2']);

                            if ($campos['envio_com_normalizacao'] == 1) {
                                $colorPill = "success";
                            } else {
                                $colorPill = "danger";
                            }




                            if ($campos['envio_com_normalizacao'] == 1) { ?>
                                <span class="btn btn-sm btn-<?= $colorPill ?> rounded-pill"><b>Enviado</b></span>
                            <?php } else { ?>
                                <span class="btn btn-sm btn-<?= $colorPill ?> rounded-pill"><b>Não Enviado</b></span>
                            <?php } ?>

                        </span>
                    </div>
                </button>

            </h2>
            <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body colorAccordion">
                    <div class="row justify-content-between">
                        <div class="col-5">
                            <b>Criador: </b> <?php if ($campos['criador'] <> null) {
                                                    echo $campos['criador'];
                                                } else {
                                                    echo "Integração Zabbix";
                                                } ?><br>
                            <b>Tipo Incidente:</b> <?php if ($campos['tipo'] <> null) {
                                                        echo $campos['tipo'];
                                                    } else {
                                                        echo "Não definido";
                                                    } ?><br>
                            <b>Classificação: </b>
                            <?php
                            if ($campos['classificacao'] == NULL) {
                                echo "Não Classificado";
                            } else {
                                echo $campos['classificacao'];
                            } ?> <br>

                        </div>
                        <div class="col-5">
                            <b>Hora Inicial: </b><?= $campos['horainicial']; ?><br>
                            <b>Previsão Normalização: </b>
                            <?php
                            if ($campos['previsaoNormalizacao'] == NULL) {
                                echo "Sem Previsão";
                            } else {
                                echo $campos['previsaoNormalizacao'];
                            } ?> <br>
                            <b>Hora Normalização: </b><?= $campos['horafinal']; ?><br>
                        </div>

                        <?php
                        if ($permissaoGerenciar == 1) { ?>
                            <div class="col-2">
                                <a href="/servicedesk/incidentes/view.php?id=<?= $id_incidente ?>" title="Visualizar">
                                    <button type="button" class="btn btn-sm btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        </svg>
                                        Ver incidente
                                    </button>
                                </a>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php $cont++;
    } ?>
</div>