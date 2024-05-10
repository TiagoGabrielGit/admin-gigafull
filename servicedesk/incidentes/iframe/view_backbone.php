<div class="accordion" id="accordionFlushExample">

<?php

$sql_incidentes =
    "SELECT
i.zabbix_event_id as zabbixID,
i.id as idIncidente,
i.incident_type as incident_type,
i.equipamento_id as equipamento_id,
i.descricaoIncidente as descricaoIncidente,
i.active as activeID,
i.active as active,
ic.classificacao as classificacao,
i.descricaoEvento as descricaoEvento,
ic.color as ClassColor,
rf.ponta_a as ponta_a,
rf.ponta_b as ponta_b,
i.previsaoNormalizacao as previsaoNormalizacao2,
it.type as tipo,
p.nome as criador,
date_format(i.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao,
date_format(i.inicioIncidente,'%H:%i:%s %d/%m/%Y') as horainicial,
date_format(i.fimIncidente,'%H:%i:%s %d/%m/%Y') as horafinal,
IF (i.fimIncidente IS NULL, TIMEDIFF(NOW(), i.inicioIncidente), TIMEDIFF(i.fimIncidente, i.inicioIncidente)) as tempoIncidente
FROM incidentes i
INNER JOIN rotas_fibra as rf ON i.equipamento_id = rf.codigo
INNER JOIN rotas_fibras_interessados as rfi ON rf.id = rfi.rf_id
LEFT JOIN incidentes_classificacao as ic ON ic.id = i.classificacao
LEFT JOIN usuarios as u ON i.autor_id = u.id LEFT JOIN pessoas as p ON p.id = u.pessoa_id
LEFT JOIN incidentes_types as it ON it.codigo = i.incident_type
WHERE rfi.interessado_empresa_id =  $empresaID AND rfi.active = 1 and i.active = 1 and i.incident_type = $tipo_incidente_codigo
ORDER BY i.active DESC, i.inicioIncidente DESC";


$r_sql_incidentes = mysqli_query($mysqli, $sql_incidentes);

$cont = 1;
while ($campos = $r_sql_incidentes->fetch_array()) {
    $id_incidente = $campos['idIncidente'];
    $identificacao = "ROTA: " . $campos['ponta_a'] . " <> " . $campos['ponta_b'];
    $status_incidente = $campos['active'];

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
                        &nbsp; &nbsp;<b>
                            <?php
                            $identificacao = strtoupper($identificacao);
                            $identificacao = mb_strtoupper($identificacao, 'utf-8');
                            echo $identificacao;
                            ?>

                        </b> <?php echo " - " .  $campos['descricaoIncidente'] ?> <br>

                        <?php if ($campos['descricaoEvento'] === NULL) { ?>
                        <?php } else { ?>
                            <span style="font-size: 13px;"><b>Descrição do Evento:</b><br><?= nl2br($campos['descricaoEvento']) ?></span><br><br>
                        <?php }
                        ?>
                    </span>
                    <span style="font-size: 13px;" class="text-end">

                        <?php
                        if ($campos['classificacao'] == NULL) { ?>
                            <span class="btn btn-extra-small btn-sm rounded-pill mb-1" style="background-color: <?= $campos['ClassColor'] ?>"><b>Não Classificado</b></span>
                        <?php } else { ?>
                            <span class="btn btn-extra-small btn-sm rounded-pill mb-1" style="background-color: <?= $campos['ClassColor'] ?>"><b><?= $campos['classificacao'] ?></b></span>
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
                            <span class="btn btn-extra-small btn-sm btn-<?= $colorPill ?> rounded-pill"><b>Sem Previsão</b></span>
                        <?php } else { ?>
                            <span class="btn btn-extra-small btn-sm btn-<?= $colorPill ?> rounded-pill"><b><?= $campos['previsaoNormalizacao'] ?></b></span>
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