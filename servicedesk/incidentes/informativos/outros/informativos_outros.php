<?php
require "../../../../includes/menu.php";
require "../../../../conexoes/conexao_pdo.php";
require "../../../../conexoes/conexao.php";

$submenu_id = "22";
$uid = $_SESSION['id'];
$incidente_code = $_GET['code'];
$permissions_submenu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    $dados_usuario =
        "SELECT
    u.empresa_id as empresaID,
    e.atributoEmpresaPropria  as atributoEmpresaPropria
    FROM usuarios as u
    LEFT JOIN empresas as e ON e.id = u.empresa_id
    LEFT JOIN redeneutra_parceiro as rnp ON rnp.empresa_id = u.empresa_id
    WHERE u.id = $uid";

    $r_dados_usuario = mysqli_query($mysqli, $dados_usuario);
    $c_dados_usuario = $r_dados_usuario->fetch_array();
    $empresaID = $c_dados_usuario['empresaID'];
    $empresaPropria = $c_dados_usuario['atributoEmpresaPropria'];

    $permissaoGerenciar = $_SESSION['permite_gerenciar_incidente'];
    $permissaoProtocoloERP = $_SESSION['permite_visualizar_protocolo_erp'];

    $incidente_type_query = "SELECT * FROM incidentes_types WHERE codigo = :incidente_code";
    $stmt = $pdo->prepare($incidente_type_query);
    $stmt->bindParam(':incidente_code', $incidente_code, PDO::PARAM_INT);
    $stmt->execute();
    $incidente_type = $stmt->fetch(PDO::FETCH_ASSOC);


    $filtro = "";

    // Verifique se o campo de evento está preenchido
    if (!empty($_GET['evento_informativo'])) {
        $evento = $_GET['evento_informativo'];
        // Adicione a condição do filtro para o campo de evento
        $filtro .= " AND LOWER(i.descricaoIncidente) LIKE LOWER('%$evento%')";
    }

    // Verifique se o campo de status está selecionado
    if (isset($_GET['status_informativo'])) {
        $status = $_GET['status_informativo'];
        // Adicione a condição do filtro para o campo de status
        $filtro .= " AND i.active LIKE '$status'";
    }

    // Verifique se o campo de classificação está selecionado
    if (!empty($_GET['classificacao_informativo'])) {
        $classificacao = $_GET['classificacao_informativo'];
        // Adicione a condição do filtro para o campo de classificação
        $filtro .= " AND i.classificacao LIKE '$classificacao'";
    }

    // Verifique se o campo de data de ocorrência está preenchido
    if (!empty($_GET['data_ocorrencia'])) {
        $data_ocorrencia = $_GET['data_ocorrencia'];
        // Adicione a condição do filtro para o campo de data de ocorrência
        $filtro .= " AND i.inicioIncidente LIKE '$data_ocorrencia%'";
    }

    // Verifique se o campo de data de normalização está preenchido
    if (!empty($_GET['data_normalizacao'])) {
        $data_normalizacao = $_GET['data_normalizacao'];
        // Adicione a condição do filtro para o campo de data de normalização
        $filtro .= " AND i.fimIncidente LIKE '$data_normalizacao%'";
    }

    // Verifique se o campo de data de normalização está preenchido
    if (!empty($_GET['limite_busca'])) {
        $limite_busca = $_GET['limite_busca'];
    } else {
        $limite_busca = "100";
    }
?>

    <style>
        .btn-extra-small {
            padding: 0.2rem 0.4rem;
            /* Ajuste os valores de padding conforme necessário */
            font-size: 0.75rem;
            /* Ajuste o tamanho da fonte conforme necessário */
        }
    </style>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="text-left">
                                    <h5 class="card-title">INFORMATIVOS - <?= $incidente_type['type'] ?>
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <form action="#" method="GET">
                                        <input hidden readonly id="code" name="code" value="<?= $incidente_code ?>">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="evento_informativo" class="form-label">Evento</label>
                                                <input id="evento_informativo" name="evento_informativo" type="text" class="form-control" value="<?php echo isset($_GET['evento_informativo']) ? htmlspecialchars($_GET['evento_informativo']) : ''; ?>">
                                            </div>
                                            <div class="col-3">
                                                <label for="status_informativo" class="form-label">Status do informativo</label>
                                                <select id="status_informativo" name="status_informativo" class="form-select">
                                                    <option value="%">Todos</option>
                                                    <option value="1" <?php echo (isset($_GET['status_informativo']) && $_GET['status_informativo'] == '1') ? 'selected' : ''; ?>>Alarmando</option>
                                                    <option value="0" <?php echo (isset($_GET['status_informativo']) && $_GET['status_informativo'] == '0') ? 'selected' : ''; ?>>Normalizado</option>
                                                </select>

                                            </div>

                                            <div class="col-3">
                                                <label for="classificacao_informativo" class="form-label">Classificação do informativo</label>
                                                <select id="classificacao_informativo" name="classificacao_informativo" class="form-select">
                                                    <option value="%">Todos</option>
                                                    <?php
                                                    $classificacoes_query = "SELECT * FROM incidentes_classificacao WHERE active = 1 ORDER BY classificacao ASC";
                                                    $result_classificacoes = $pdo->query($classificacoes_query);
                                                    if ($result_classificacoes) {
                                                        while ($classificacao = $result_classificacoes->fetch(PDO::FETCH_ASSOC)) {
                                                            $classificacao_id = $classificacao['id'];
                                                            $classificacao_nome = $classificacao['classificacao'];
                                                            $selected = (isset($_GET['classificacao_informativo']) && $_GET['classificacao_informativo'] == $classificacao_id) ? 'selected' : '';
                                                    ?>
                                                            <option value="<?= $classificacao_id; ?>" <?= $selected; ?>><?= $classificacao_nome; ?></option>

                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-4">
                                                <label for="data_ocorrencia" class="form-label">Data ocorrência informativo</label>
                                                <input id="data_ocorrencia" name="data_ocorrencia" class="form-control" type="date" value="<?php echo isset($_GET['data_ocorrencia']) ? htmlspecialchars($_GET['data_ocorrencia']) : ''; ?>">
                                            </div>
                                            <div class="col-4">
                                                <label for="data_normalizacao" class="form-label">Data normalização informativo</label>
                                                <input id="data_normalizacao" name="data_normalizacao" class="form-control" type="date" value="<?php echo isset($_GET['data_normalizacao']) ? htmlspecialchars($_GET['data_normalizacao']) : ''; ?>">
                                            </div>


                                            <div class="col-2">
                                                <label for="limite_busca" class="form-label">Limite de busca</label>
                                                <select id="limite_busca" name="limite_busca" class="form-select">
                                                    <option value="10">10</option>
                                                    <option value="50">50</option>
                                                    <option value="100" selected>100</option>
                                                </select>
                                            </div>
                                            <div style="text-align: center; margin-top: 35px;" class="col-2">
                                                <button class="btn btn-sm btn-danger" type="submit">Aplicar Filtros</button>
                                            </div>


                                        </div>
                                        <br>
                                    </form>
                                </div>

                                <div class="col-2">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href = '/servicedesk/incidentes/informativos/informativos.php';">Voltar informativos</button>
                                </div>
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
                                    WHERE it.codigo = $incidente_code $filtro
                                    ORDER BY i.active DESC, i.id DESC
                                    LIMIT $limite_busca";


                                $r_sql_incidentes = mysqli_query($mysqli, $sql_incidentes);

                                $cont = 1;
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
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    require "../../../../acesso_negado.php";
}
require "../../../../includes/securityfooter.php";
?>