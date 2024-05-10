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
    i.protocolo_erp as protocoloERP,
    i.pon_id as pon_id,
    i.active as active,
    i.descricaoEvento as descricaoEvento,
    ic.classificacao as classificacao,
    ic.descricao as descClassificacao,
    ic.color as ClassColor,
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
    WHERE oi.interessado_empresa_id = $empresaID AND oi.active = 1 AND i.active = 1 AND i.incident_type = $tipo_incidente_codigo
    ORDER BY i.active DESC, i.inicioIncidente DESC";


$r_sql_incidentes = mysqli_query($mysqli, $sql_incidentes);

$cont = 1;

while ($campos = $r_sql_incidentes->fetch_array()) {
    $status_incidente = $campos['active'];
    $id_incidente = $campos['idIncidente'];
    $pon_id = $campos['pon_id'];
    $hostID = $campos['equipamento_id'];
    $sql_host =
        "SELECT eqp.hostname as identificacao
FROM equipamentospop as eqp
WHERE eqp.id = $hostID";

    $r_host = mysqli_query($mysqli, $sql_host);
    $c_host = $r_host->fetch_array();


    if ($status_incidente == 1) {
        $styleIncidente = "styleTableIncidentesAlarm";
    } else {
        $styleIncidente = "styleTableIncidentesOK";
    }

?>

    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-heading<?= $cont ?>">
            <button class="accordion-button collapsed" id="<?= $styleIncidente ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <span class="text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" stroke="black" fill="black" class="bi bi-flag-fill" viewBox="0 0 16 16">
                            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"></path>
                        </svg>
                        &nbsp; &nbsp;
                        <b><?= $campos['descricaoIncidente'] ?></b>
                        <br>
                        <?php if ($campos['descricaoEvento'] === NULL) { ?>
                        <?php } else { ?>
                            <span style="font-size: 13px;"><b>Descrição do Evento:</b><br><?= nl2br($campos['descricaoEvento']) ?></span><br><br>
                        <?php }
                        ?>

                        <?php
                        $ctos_afetadas =
                            "SELECT gc.title
                            FROM incidentes_ctos as ic
                            LEFT JOIN gpon_ctos as gc ON gc.id = ic.cto_id
                            WHERE ic.incidente_id = :incidente_id";
                                $sql_ctos_afetadas = $pdo->prepare($ctos_afetadas);
                                $sql_ctos_afetadas->bindParam(':incidente_id', $id_incidente, PDO::PARAM_INT);
                                $sql_ctos_afetadas->execute();
                                $ctos = $sql_ctos_afetadas->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($ctos)) { ?>
                            <b>CTOs Afetadas:</b><br>
                            <div class="row">

                                <?php $count = 0;

                                foreach ($ctos as $row) {
                                    if ($count % 3 === 0 && $count > 0) { ?>
                            </div>
                            <div class="row">
                            <?php } ?>

                            <div class="col">
                                <?= $row['title'] ?><br>
                            </div>
                        <?php $count++;
                                } ?>

                            </div>
                        <?php } else { ?>
                            <span style="font-size: 13px;">Nenhuma CTO vinculada ao incidente.</span>
                        <?php }
                        ?>
                        <br>

                    </span>
                    <span style="font-size: 13px;" class="text-end">

                        <?php
                        if ($campos['classificacao'] == NULL) { ?>
                            <span title="<?= $campos['descClassificacao'] ?>" class="btn btn-extra-small btn-sm rounded-pill mb-1" style="background-color: <?= $campos['ClassColor'] ?>"><b>Não Classificado</b></span>
                        <?php } else { ?>
                            <span title="<?= $campos['descClassificacao'] ?>" class="btn btn-extra-small btn-sm rounded-pill mb-1" style="background-color: <?= $campos['ClassColor'] ?>"><b><?= $campos['classificacao'] ?></b></span>
                        <?php } ?>

                        <?php
                        $currentDate = strtotime(date("Y-m-d H:i:s"));
                        if ($campos['previsaoNormalizacao2'] === null) {
                        } else {
                            $previsaoNormalizacao = strtotime($campos['previsaoNormalizacao2']);
                        }
                        if ($campos['previsaoNormalizacao2'] === null) {
                            $colorPill = "secondary";
                        } else if ($previsaoNormalizacao < $currentDate) {
                            $colorPill = "danger";
                        } else if ($previsaoNormalizacao > $currentDate) {
                            $colorPill = "info";
                        }

                        if ($campos['previsaoNormalizacao'] == NULL) { ?>
                            <span title="Previsão de Normalização" class="btn btn-extra-small btn-sm btn-<?= $colorPill ?> rounded-pill"><b>Sem Previsão</b></span>
                        <?php } else { ?>
                            <span title="Previsão de Normalização" class="btn btn-extra-small btn-sm btn-<?= $colorPill ?> rounded-pill"><b><?= $campos['previsaoNormalizacao'] ?></b></span>
                        <?php } ?>
                        <br><br>
                        <b>Tempo total incidente: </b><?= $campos['tempoIncidente']; ?>
                        <br>
                        <?= (!empty($campos['protocoloERP'])) ? '<b> Protocolo ERP: </b> ' . $campos['protocoloERP'] : '' ?>
                    </span>
                </div>
            </button>

        </h2>
    </div>
<?php $cont++;
} ?>
</div>