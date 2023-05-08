<div class="accordion" id="accordionFlushExample">

    <?php

    // Verifica se a variável tá declarada, senão deixa na primeira página como padrão
    if (isset($_GET["pagina"])) {
        $p = $_GET["pagina"];
    } else {
        $p = 1;
    }
    // Defina aqui a quantidade máxima de registros por página.
    $qnt = 20;

    // O sistema calcula o início da seleção calculando: 
    // (página atual * quantidade por página) - quantidade por página
    $inicio = ($p * $qnt) - $qnt;


    if ($campo_parceiro['parceiro'] == NULL) {
        $sql_incidentes =
            "SELECT
        rni.id as idIncidente,
        rni.zabbix_event_id as zabbixID,
        eqpop.hostname as equipamento,
        rni.descricaoIncidente as descricaoIncidente,
        ic.classificacao as classificacao,
        rni.descricaoIncidente as descricaoIncidente,
        CASE
        WHEN rni.active = 1 THEN 'Incidente aberto'
        WHEN rni.active = 0 THEN 'Normalizado'
        END active,
        rni.active as activeID,
        date_format(rni.inicioIncidente,'%H:%i:%s %d/%m/%Y') as horainicial,
        date_format(rni.fimIncidente,'%H:%i:%s %d/%m/%Y') as horafinal,
        date_format(rni.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao,
        IF (rni.fimIncidente IS NULL, TIMEDIFF(NOW(), rni.inicioIncidente), TIMEDIFF(rni.fimIncidente, rni.inicioIncidente)) as tempoIncidente
        FROM
        redeneutra_incidentes as rni
        LEFT JOIN
        equipamentospop as eqpop
        ON
        eqpop.id = rni.equipamento_id
        LEFT JOIN
        incidentes_classificacao as ic
        ON
        ic.id = rni.classificacao
        WHERE
        rni.previsaoNormalizacao < NOW()
        and
        rni.active = 1
        ORDER BY
        rni.inicioIncidente DESC
        LIMIT $inicio, $qnt";
    } else {
        $sql_incidentes =
            "SELECT
        rni.id as idIncidente,
        rni.zabbix_event_id as zabbixID,
        eqpop.hostname as equipamento,
        rni.descricaoIncidente as descricaoIncidente,
        ic.classificacao as classificacao,
        rni.descricaoIncidente as descricaoIncidente,
        CASE
        WHEN rni.active = 1 THEN 'Incidente aberto'
        WHEN rni.active = 0 THEN 'Normalizado'
        END active,
        rni.active as activeID,
        date_format(rni.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao,
        date_format(rni.inicioIncidente,'%H:%i:%s %d/%m/%Y') as horainicial,
        date_format(rni.fimIncidente,'%H:%i:%s %d/%m/%Y') as horafinal,
        IF (rni.fimIncidente IS NULL, TIMEDIFF(NOW(), rni.inicioIncidente), TIMEDIFF(rni.fimIncidente, rni.inicioIncidente)) as tempoIncidente
        FROM
        redeneutra_parceiro_olt as rnpo
        LEFT JOIN
        redeneutra_olts as rno
        ON
        rno.id = rnpo.olt_id
        LEFT JOIN
        redeneutra_incidentes as rni
        ON
        rni.equipamento_id = rno.equipamento_id
        LEFT JOIN
        equipamentospop as eqpop
        ON
        eqpop.id = rni.equipamento_id
        LEFT JOIN
        incidentes_classificacao as ic
        ON
        ic.id = rni.classificacao
        WHERE
        rni.previsaoNormalizacao < NOW()
        and
        rnpo.parceiro_id = $parceiroID
        and
        rnpo.active = 1
        and rni.active = 1
        ORDER BY
        rni.inicioIncidente DESC
        LIMIT $inicio, $qnt";
    }

    $r_sql_incidentes = mysqli_query($mysqli, $sql_incidentes);

    $cont = 1;
    while ($campos = $r_sql_incidentes->fetch_array()) {
        $id_incidente = $campos['idIncidente'];
        if ($campos['activeID'] == "1") {
            $estiloTable = "styleTableIncidentesAlarm";
            $corBandeira = "black";
        } else if ($campos['activeID'] == "0") {
            $estiloTable = "styleTableIncidentesOK";
            $corBandeira = "black";
        }
    ?>

        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading<?= $cont ?>">
                <button class="accordion-button collapsed" id="<?= $estiloTable ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" stroke="black" fill="<?= $corBandeira ?>" class="bi bi-flag-fill" viewBox="0 0 16 16">
                        <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"></path>
                    </svg> &nbsp; &nbsp; Incidente: <?= $campos['descricaoIncidente'] ?>
                </button>
            </h2>
            <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body colorAccordion">
                    <div class="row justify-content-between">
                        <div class="col-5">
                            <b>Equipamento: </b><?= $campos['equipamento'] ?><br>
                            <b>Autor: </b> <?php if ($campos['zabbixID'] <> null) {
                                                echo "Integração Zabbix";
                                            } ?><br>



                            <b>Classificação: </b>
                            <?php
                            if ($campos['classificacao'] == NULL) {
                                echo "Não Classificado";
                            } else {
                                echo $campos['classificacao'];
                            } ?> <br>


                            <b>Previsão Normalização: </b>
                            <?php
                            if ($campos['previsaoNormalizacao'] == NULL) {
                                echo "Sem Previsão";
                            } else {
                                echo $campos['previsaoNormalizacao'];
                            } ?> <br>

                        </div>
                        <div class="col-5">
                            <b>Hora Inicial: </b><?= $campos['horainicial']; ?><br>
                            <b>Hora Normalização: </b><?= $campos['horafinal']; ?><br><br>
                            <b>Tempo total incidente: </b><?= $campos['tempoIncidente']; ?>
                        </div>
                        <div class="col-2">
                            <a href="/servicedesk/incidentes/view.php?id=<?= $id_incidente ?>&status=open" title="Visualizar">
                                <button type="button" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                    </svg>
                                    Ver incidente
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $cont++;
    }

    // Depois que selecionou todos os nome, pula uma linha para exibir os links(próxima, última...)
    echo "<br />";

    // Faz uma nova seleção no banco de dados, desta vez sem LIMIT,
    // para pegarmos o número total de registros
    if ($campo_parceiro['parceiro'] == NULL) {
        $sql_select_all =
            "SELECT
        rni.id as idIncidente,
        rni.zabbix_event_id as zabbixID,
        eqpop.hostname as equipamento,
        rni.descricaoIncidente as descricaoIncidente,
        CASE
        WHEN rni.active = 1 THEN 'Incidente aberto'
        WHEN rni.active = 0 THEN 'Normalizado'
        END active,
        rni.active as activeID,
        date_format(rni.inicioIncidente,'%H:%i:%s %d/%m/%Y') as horainicial,
        date_format(rni.fimIncidente,'%H:%i:%s %d/%m/%Y') as horafinal,
        IF (rni.fimIncidente IS NULL, TIMEDIFF(NOW(), rni.inicioIncidente), TIMEDIFF(rni.fimIncidente, rni.inicioIncidente)) as tempoIncidente
        FROM
        redeneutra_incidentes as rni
        LEFT JOIN
        equipamentospop as eqpop
        ON
        eqpop.id = rni.equipamento_id

        where
        rni.previsaoNormalizacao < NOW()
        and
         rni.active = 1
        
        ORDER BY
        rni.inicioIncidente DESC";
    } else {
        $sql_select_all =
            "SELECT
        rni.id as idIncidente,
        rni.zabbix_event_id as zabbixID,
        eqpop.hostname as equipamento,
        rni.descricaoIncidente as descricaoIncidente,
        CASE
        WHEN rni.active = 1 THEN 'Incidente aberto'
        WHEN rni.active = 0 THEN 'Normalizado'
        END active,
        rni.active as activeID,
        date_format(rni.inicioIncidente,'%H:%i:%s %d/%m/%Y') as horainicial,
        date_format(rni.fimIncidente,'%H:%i:%s %d/%m/%Y') as horafinal,
        IF (rni.fimIncidente IS NULL, TIMEDIFF(NOW(), rni.inicioIncidente), TIMEDIFF(rni.fimIncidente, rni.inicioIncidente)) as tempoIncidente
        FROM
        redeneutra_parceiro_olt as rnpo
        LEFT JOIN
        redeneutra_olts as rno
        ON
        rno.id = rnpo.olt_id
        LEFT JOIN
        redeneutra_incidentes as rni
        ON
        rni.equipamento_id = rno.equipamento_id
        LEFT JOIN
        equipamentospop as eqpop
        ON
        eqpop.id = rni.equipamento_id
        WHERE
        rni.previsaoNormalizacao < NOW()
        and
        rnpo.parceiro_id = $parceiroID
        and
        rnpo.active = 1
        and rni.active = 1
        ORDER BY
        rni.inicioIncidente DESC";
    }


    // Executa o query da seleção acimas
    $sql_query_all = mysqli_query($mysqli, $sql_select_all);


    // Gera uma variável com o número total de registros no banco de dados
    $total_registros = mysqli_num_rows($sql_query_all);

    // Gera outra variável, desta vez com o número de páginas que será precisa.
    // O comando ceil() arredonda "para cima" o valor

    if ($total_registros == "0") {
        $pags = "1";
    } else {
        $pags = ceil($total_registros / $qnt);
    }

    // Número máximos de botões de paginação
    $max_links = 5; ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php
            // Exibe o primeiro link "primeira página", que não entra na contagem acima(3)
            ?>
            <li class="page-item"><a class="page-link" href="/servicedesk/incidentes/index.php?pagina=1">Primeira Página</a></li>
            <?php
            // Cria um for() para exibir os 3 links antes da página atual
            for ($i = $p - $max_links; $i <= $p - 1; $i++) {
                // Se o número da página for menor ou igual a zero, não faz nada
                // (afinal, não existe página 0, -1, -2..)
                if ($i <= 0) {
                    //faz nada
                    // Se estiver tudo OK, cria o link para outra página
                } else {
            ?>

                    <li class="page-item"><a class="page-link" href="/servicedesk/incidentes/index.php?pagina=<?= $i ?>"><?= $i ?></a></li>
            <?php

                }
            }
            // Exibe a página atual, sem link, apenas o número
            ?>
            <li class="page-item active"><a class="page-link"><?= $p ?></a></li>
            <?php
            // Cria outro for(), desta vez para exibir 3 links após a página atual
            for ($i = $p + 1; $i <= $p + $max_links; $i++) {
                // Verifica se a página atual é maior do que a última página. Se for, não faz nada.
                if ($i > $pags) {
                    //faz nada
                }
                // Se tiver tudo Ok gera os links.
                else {
            ?>

                    <li class="page-item"><a class="page-link" href="/servicedesk/incidentes/index.php?pagina=<?= $i ?>"><?= $i ?></a></li>
            <?php
                }
            }
            // Exibe o link "última página"
            ?>

            <li class="page-item"><a class="page-link" href="/servicedesk/incidentes/index.php?pagina=<?= $pags ?>">Última Página</a></li>
        </ul>
    </nav><!-- End Basic Pagination -->
</div>