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
    LEFT JOIN incidentes_classificacao as ic ON ic.id = i.classificacao
    LEFT JOIN usuarios as u ON i.autor_id = u.id LEFT JOIN pessoas as p ON p.id = u.pessoa_id
    LEFT JOIN incidentes_types as it ON it.codigo = i.incident_type
    WHERE it.codigo = $tipo_incidente_codigo and i.active = 1
    ORDER BY i.active DESC, i.id DESC";


    $r_sql_incidentes = mysqli_query($mysqli, $sql_incidentes);

    $cont = 1;


    if (mysqli_num_rows($r_sql_incidentes) == 0) {
        echo "<div class='alert alert-info'>Nenhum incidente.</div>";
    } else {
        while ($campos = $r_sql_incidentes->fetch_array()) {
            $status_incidente = $campos['active'];
            $id_incidente = $campos['idIncidente'];


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
                                <b>Protocolo ERP: </b> <?= $campos['protocoloERP'] ?> <br>

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
                            <div class="col-2">
                                <?php
                                if ($permissaoGerenciar == 1) { ?>
                                    <div class="col-12">
                                        <a href="/servicedesk/incidentes/informativos/outros/view_outros.php?id=<?= $id_incidente ?>" title="Visualizar">
                                            <button type="button" class="btn btn-sm btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                </svg>
                                                Ver incidente
                                            </button>
                                        </a>
                                    </div>
                                    <br>
                                <?php
                                } ?>
                                <div class="row">

                                    <div class="col-1">
                                    </div>
                                    <?php
                                    if (isset($permissaoProtocoloERP) == 1 && !empty($campos['protocoloERP']) || isset($protocoloERP) && $protocoloERP == 1 && !empty($campos['protocoloERP'])) { ?>
                                        <div class="col-2">
                                            <form method="POST" action="/servicedesk/incidentes/protocolo_erp.php">
                                                <input hidden readonly id="protocoloERP" name="protocoloERP" value="<?= $campos['protocoloERP'] ?>">
                                                <button title="Solicitação ERP" type="submit" class="btn btn-sm btn-info"><i class="bi bi-box-arrow-right"></i></button>
                                            </form>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php $cont++;
        }
    } ?>
</div>