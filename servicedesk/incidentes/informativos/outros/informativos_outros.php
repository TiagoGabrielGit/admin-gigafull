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
?>

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
                                <div class="text-end">
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
                                    WHERE it.codigo = $incidente_code
                                    ORDER BY i.active DESC, i.inicioIncidente DESC
                                    LIMIT 100";


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
                                                        &nbsp; &nbsp;<b>
                                                            <?= $campos['descricaoIncidente'] ?>

                                                        </b> <br>
                                                      
                                                        <br>
                                                        <b>&nbsp; &nbsp; &nbsp; &nbsp;Tempo total incidente: </b><?= $campos['tempoIncidente']; ?> <?= (!empty($campos['protocoloERP'])) ? '- <b> Protocolo ERP: </b> ' . $campos['protocoloERP'] : '' ?>

                                                    </span>
                                                    <span class="text-end">

                                                        <?php
                                                        if ($campos['classificacao'] == NULL) { ?>
                                                            <span title="<?= $campos['descClassificacao'] ?>" class="btn btn-sm rounded-pill mb-1" style="background-color: <?= $campos['ClassColor'] ?>"><b>Não Classificado</b></span>
                                                        <?php } else { ?>
                                                            <span title="<?= $campos['descClassificacao'] ?>" class="btn btn-sm rounded-pill mb-1" style="background-color: <?= $campos['ClassColor'] ?>"><b><?= $campos['classificacao'] ?></b></span>
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
                                                            <span title="Previsão de Normalização" class="btn btn-sm btn-<?= $colorPill ?> rounded-pill"><b>Sem Previsão</b></span>
                                                        <?php } else { ?>
                                                            <span title="Previsão de Normalização" class="btn btn-sm btn-<?= $colorPill ?> rounded-pill"><b><?= $campos['previsaoNormalizacao'] ?></b></span>
                                                        <?php } ?>
                                                        <!-- </div>-->
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
                                                            <br>
                                                        <?php
                                                        } ?>
                                                        <div class="row">

                                                            <div class="col-2">
                                                                <button title="Localidades" type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalLocalidades<?= $cont ?>"><i class="bi bi-pin-map"></i></button>
                                                            </div>
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
                                                        <div class="modal fade" id="modalLocalidades<?= $cont ?>" tabindex="-1">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Localidades</h5>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="card-body">
                                                                            <div class="col-12">
                                                                                <table class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th style="text-align: center;">Cidade</th>
                                                                                            <th style="text-align: center;">Bairro</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                        // Preparar e executar a consulta SQL usando PDO
                                                                                        $localidades_query = "SELECT cidade, bairro FROM gpon_localidades WHERE pon_id = :pon_id AND active = 1";
                                                                                        $stmt_localidades = $pdo->prepare($localidades_query);
                                                                                        $stmt_localidades->bindParam(':pon_id', $pon_id);
                                                                                        $stmt_localidades->execute();

                                                                                        // Verificar se há resultados
                                                                                        if ($stmt_localidades->rowCount() > 0) {
                                                                                            // Iterar pelos resultados e criar as linhas da tabela
                                                                                            while ($row = $stmt_localidades->fetch(PDO::FETCH_ASSOC)) {
                                                                                                echo '<tr>';
                                                                                                echo '<td style="text-align: center;">' . $row['cidade'] . '</td>';
                                                                                                echo '<td style="text-align: center;">' . $row['bairro'] . '</td>';
                                                                                                echo '</tr>';
                                                                                            }
                                                                                        } else {
                                                                                            // Caso não haja resultados
                                                                                            echo '<tr><td colspan="2" style="text-align: center;">Nenhuma localidade encontrada.</td></tr>';
                                                                                        }
                                                                                        ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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