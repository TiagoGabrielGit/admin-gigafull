<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "49";
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
    $permite_interagir_chamados = $_SESSION['permite_interagir_chamados'];
    $atributoEmpresaPropria = $_SESSION['atributoEmpresaPropria'];
    $idPessoa = $_SESSION['id_pessoa'];
    $id_chamado = $_GET['id'];
    $equipe_id = $_SESSION['equipe_id'];
    $empresa_usuario = $_SESSION['empresa_id'];
    $permite_atender_chamados = $_SESSION['permite_atender_chamados'];
    $permite_atender_chamados_outras_empresas = $_SESSION['permite_atender_chamados_outras_empresas'];

    $query_chamado =
        "SELECT
        c.id as id_chamado,
        c.assuntoChamado as assunto,
        c.relato_inicial as relato_inicial,
        c.solicitante_id as solicitante_id,
        c.solicitante_equipe_id as solicitante_equipe_id,
        c.prioridade as prioridade,
        tc.afericao as afericao,
        date_format(c.data_abertura,'%H:%i:%s %d/%m/%Y') as abertura,
        date_format(c.data_fechamento,'%H:%i:%s %d/%m/%Y') as fechado,
        c.atendente_id as id_atendente,
        c.in_execution as in_execution,
        c.in_execution_atd_id as in_execution_atd_id,
        c.in_execution_start as in_execution_start,
        c.data_prevista_conclusao as 'data_prevista_conclusao',
        c.melhoria_recomendada as 'melhoria_recomendada',
        tc.tipo as tipo,
        tc.id as tipo_id,
        f.status as afericao_status,
        cs.status_chamado as status,
        e.fantasia as empresa,
        e.id as idEmpresa,
        s.service as service,
        ise.item as itemService,
        p.nome as solicitante_nome,
        pes.nome as atendente_nome
        FROM chamados as c 
        LEFT JOIN chamado_relato as cr ON c.id = cr.chamado_id
        LEFT JOIN tipos_chamados as tc ON c.tipochamado_id = tc.id
        LEFT JOIN chamados_status as cs ON c.status_id = cs.id
        LEFT JOIN usuarios as u ON u.id = c.solicitante_id 
        LEFT JOIN pessoas as p ON p.id = u.pessoa_id
        LEFT JOIN empresas as e ON e.id = c.empresa_id
        LEFT JOIN usuarios as us ON us.id = c.atendente_id
        LEFT JOIN pessoas as pes ON pes.id = us.pessoa_id
        LEFT JOIN contract_service as cser ON cser.id = c.service_id
        LEFT JOIN service as s ON s.id = cser.service_id
        LEFT JOIN contract_iten_service as cis ON cis.id = c.iten_service_id
        LEFT JOIN iten_service as ise ON ise.id = cis.iten_service
        LEFT JOIN afericao as f ON f.chamado_id = c.id
        WHERE c.id = '$id_chamado'";

    $r_chamado = mysqli_query($mysqli, $query_chamado);
    $chamado = mysqli_fetch_assoc($r_chamado);

    if (($permite_interagir_chamados == 1 && ($chamado['idEmpresa'] == $empresa_usuario)) || ($permite_interagir_chamados == 2 & ($chamado['solicitante_equipe_id'] == $equipe_id)) || ($permite_interagir_chamados == 3)) {

        if ($chamado['in_execution'] == 1) {
            $classeColor = "playColor";
        } else {
            $classeColor = "";
        }

        $currentDate = strtotime(date("Y-m-d H:i:s")); // Data atual em formato timestamp
        if ($chamado['data_prevista_conclusao'] !== null) {
            $dataPrevistaConclusao = strtotime($chamado['data_prevista_conclusao']); // Data prevista em formato timestamp
            // Restante do seu código que utiliza $timestamp
        } else {
            // Lógica para lidar com o caso em que $datetime é nulo
        }

        if ($chamado['data_prevista_conclusao'] === null) {
        } elseif ($dataPrevistaConclusao < $currentDate) {
            $colorPill = "danger";
        } elseif (($dataPrevistaConclusao - $currentDate) < 86400) {
            $colorPill = "Warning";
        } else {
            $colorPill = "success";
        }

        $usuario_ocupado =
            "SELECT count(*) as qtde
            FROM chamados as c
            WHERE c.in_execution = 1 and c.in_execution_atd_id = $idPessoa";

        $r_usuario_ocupado = mysqli_query($mysqli, $usuario_ocupado);
        $c_usuario_ocupado = mysqli_fetch_assoc($r_usuario_ocupado);
?>
        <style>
            .btn-small {
                font-size: 12px;
                padding: 4px 8px;
            }

            .playColor {
                border-radius: 6px;
                background-color: #98FB98;
                margin-top: 15px;

            }

            .playColor p {
                margin-left: 20px;
            }
        </style>

        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Chamado #<?= $id_chamado ?></h1>
            </div>

            <?php
            if (isset($_GET['success'])) {
                $successMessage = $_GET['success'];

                if ($successMessage == 1) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo 'Cancelado execução de chamado.';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }

                if ($successMessage == 2) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    echo 'Cancelada execução de chamado.';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
            } else if (isset($_GET['error'])) {
                $errorMessage = $_GET['error'];

                if ($errorMessage == 1) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo 'Nenhum chamado encontrado com o ID informado.';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
            }
            ?>

            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="col-12">
                                    <h5 class="card-title <?= $classeColor ?>">
                                        <p>Chamado <?= $id_chamado ?> - <?= $chamado['tipo']; ?> - <?= $chamado['assunto']; ?></p>
                                    </h5>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="col-12">
                                        <?php
                                        $calc_tempo_total =
                                            "SELECT SUM(seconds_worked) as secondsTotal
                                                    from chamados
                                                    where id = $id_chamado";

                                        $seconds_total = mysqli_query($mysqli, $calc_tempo_total);
                                        $res_second = $seconds_total->fetch_array();
                                        ?>
                                        <b>Tipo Chamado:</b> <?= $chamado['tipo']; ?> <br>
                                        <b>Empresa:</b> <?= $chamado['empresa']; ?> <br>
                                        <b>Solicitante:</b> <?= $chamado['solicitante_nome']; ?><br>
                                        <b>Atendente:</b> <?= $chamado['atendente_nome'] ?><br>
                                        <b>Tempo total de atendimento:</b> <?= gmdate("H:i:s", $res_second['secondsTotal']); ?> <br>
                                        <br>
                                        <?php if ($chamado['data_prevista_conclusao'] === null) {
                                        } else {
                                            if ($chamado['status'] != "Fechado") { ?>
                                                <span title="Data prevista de conclusão" class="btn btn-small btn-<?= $colorPill ?> rounded-pill"><?= date('d/m/Y H:i:s', strtotime($chamado['data_prevista_conclusao'])) ?></span>
                                            <?php } else { ?>
                                                <span title="Data prevista de conclusão" class="btn btn-small btn-secondary rounded-pill"><?= date('d/m/Y H:i:s', strtotime($chamado['data_prevista_conclusao'])) ?></span>
                                            <?php }
                                            ?>
                                        <?php } ?>

                                        <?php if (isset($chamado['prioridade'])) { ?>
                                            <span class="badge bg-warning  text-dark">Prioridade: <?= $chamado['prioridade'] ?></span>
                                        <?php } ?>


                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="col-12">
                                        <b>Serviço: </b><?= $chamado['service']; ?><br>
                                        <b>Item de Serviço: </b><?= $chamado['itemService']; ?><br>
                                        <b>Data abertura: </b><?= $chamado['abertura']; ?> <br>
                                        <b>Data fechamento: </b><?= $chamado['fechado']; ?> <br>
                                        <b>Status: </b><?= $chamado['status']; ?> <br><br>
                                    </div>
                                </div>

                                <?php
                                $valida_competencia =
                                    "SELECT cc.competencia_id as competencia_id
                                    FROM chamados_competencias as cc
                                    WHERE cc.chamado_id = $id_chamado
                                    AND NOT EXISTS (
                                    SELECT id_competencia
                                    FROM usuario_competencia as uc
                                    WHERE uc.id_usuario = $uid
                                    AND uc.id_competencia = cc.competencia_id)";

                                $r_valida_competencia = mysqli_query($mysqli, $valida_competencia);
                                $r_valida_competencia2 = mysqli_query($mysqli, $valida_competencia);
                                $c_valida_competencia = $r_valida_competencia->fetch_array();
                                $c_valida_competencia2 = $r_valida_competencia2->fetch_array();

                                ?>
                                <div class="col-lg-4 text-center">
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="consultar_chamados.php">
                                                <button type="button" class="btn btn-sm btn-danger">
                                                    Listagem Chamados
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12 " style="margin-top: 5px;">
                                            <?php if ($permite_atender_chamados == 1) { ?>
                                                <?php if (/*$c_valida_competencia == null &&*/$uid != $chamado['id_atendente'] && $chamado['status'] != "Fechado" && $chamado['in_execution'] == '0') {
                                                    if (($_SESSION['permite_atender_chamados_outras_empresas'] == 1) || ($_SESSION['permite_atender_chamados_outras_empresas'] == 0 && ($empresa_usuario == $chamado['idEmpresa']))) { ?>
                                                        <a href="processa/apropriar.php?id=<?= $id_chamado ?>&user_id=<?= $uid ?>"><button title="Apropriar" type="button" class="btn btn-info"><i class="bi bi-pin"></i></button></a>
                                                <?php }
                                                } ?>

                                                <?php if ($c_usuario_ocupado['qtde'] == '0' && $uid == $chamado['id_atendente'] && $chamado['in_execution'] == '0' && $chamado['status'] != "Fechado") {
                                                    if (($_SESSION['permite_atender_chamados_outras_empresas'] == 1)
                                                        ||
                                                        ($_SESSION['permite_atender_chamados_outras_empresas'] == 0 && ($empresa_usuario == $chamado['idEmpresa']))
                                                    ) { ?>
                                                        <a href=" processa/executar.php?id=<?= $id_chamado ?>&pessoa=<?= $idPessoa ?> "><button title=" Executar chamado" type="button" class="btn btn-success"><i class="bi bi-file-play"></i></button></a>
                                                <?php }
                                                } ?>

                                                <?php if ($chamado['status'] != "Fechado" && $_SESSION['permite_gerenciar_interessados'] == 1) { ?>
                                                    <button title="Interessados no chamado" type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalInteressados"><i class="bi bi-people"></i></button>
                                                <?php } ?>

                                                <?php if ($chamado['status'] != "Fechado" &&  $chamado['in_execution'] == '0' && $_SESSION['permite_encaminhar_chamados'] == 1) { ?>
                                                    <button title="Encaminhar Chamado" type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalEncaminhar"><i class="bi bi-arrow-left-right"></i></button>
                                                <?php } ?>

                                                <?php if ($chamado['status'] != "Fechado" && $_SESSION['permite_alterar_configuracoes_chamado'] == 1) { ?>
                                                    <button title="Configurações do Chamado" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalConfiguracoesChamados"><i class="bi bi-gear"></i></button>
                                                <?php } ?>

                                                <?php /* if ($c_valida_competencia == null) { ?>
                                                    <button title="Qualificado para atender" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalQualificacao"><i class="bi bi-award"></i></button>
                                                <?php } else { ?>
                                                    <button title="Não qualificado para atender" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalQualificacao"><i class="bi bi-award"></i></button>
                                                <?php } */ ?>

                                                <?php if ($uid == $chamado['id_atendente'] && $chamado['in_execution'] == '1' && $chamado['in_execution_atd_id'] == $idPessoa) { ?>
                                                    <button title="Inserir um relato" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal"><i class="bi bi-pencil-square"></i></button>
                                                <?php } ?>

                                                <button title="Gerar relatório do chamado" type="button" class="btn btn-info">
                                                    <a href="/tcpdf/export/relatorio_chamados.php?id=<?= $id_chamado ?>" target="_blank">
                                                        <i class="bi bi-cloud-download"></i>
                                                    </a>
                                                </button>

                                                <?php if ($chamado['afericao'] == 1) { ?>
                                                    <button title="Aferição" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalAfericao"><i class="bi bi-diagram-3"></i></button>
                                                <?php } ?>

                                            <?php } ?>

                                            <?php if ($uid != $chamado['id_atendente']) { ?>
                                                <button title="Inserir um relato" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#relatoAvulso"><i class="bi bi-pencil-square"></i></button>
                                            <?php } ?>

                                            <button title="Anexos" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalAnexos"><i class="bi bi-paperclip"></i></button>

                                            <?php if ($chamado['status'] == "Fechado") { ?>
                                                <button title="Reabrir Chamado" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalReabrirChamado"><i class="bi-arrow-repeat"></i></button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="col-12">
                                        <b>Descrição: </b><br><?= nl2br($chamado['relato_inicial']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="accordion" id="accordionFlushExample">
                            <?php


                            $sql_relatos =
                                "SELECT
                                cr.id as id_relato,
                                cr.chamado_id as id_chamado,
                                cr.private as privacidade,
                                p.nome as relatante,
                                cr.relato as relato,
                                date_format(cr.relato_hora_inicial,'%H:%i:%s %d/%m/%Y') as inicio,
                                date_format(cr.relato_hora_final,'%H:%i:%s %d/%m/%Y') as final,
                                cr.seconds_worked as seconds_worked
                                FROM
                                chamado_relato as cr
                                LEFT JOIN
                                usuarios as u
                                ON
                                u.id = cr.relator_id
                                LEFT JOIN
                                pessoas as p
                                ON
                                p.id = u.pessoa_id
                                WHERE
                                cr.chamado_id = '$id_chamado'
                                ORDER BY
                                cr.id DESC
                                ";

                            $resultado_relatos = mysqli_query($mysqli, $sql_relatos)  or die("Erro ao retornar dados");
                            $cont = 1;
                            while ($campos = $resultado_relatos->fetch_array()) {
                                if ($atributoEmpresaPropria == 1 || ($atributoEmpresaPropria == 0 & $campos['privacidade'] == 1)) {
                                    $id_relato = $campos['id_relato'];
                                    $tempoAtendimento = gmdate("H:i:s", $campos['seconds_worked']);
                                    $private = $campos['privacidade'];
                            ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-heading<?= $cont ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <span class="text-left">
                                                        Relato #<?= $id_relato ?> - <?= $campos['relatante']; ?>
                                                    </span>
                                                    <span class="text-end">
                                                        <?= $campos['inicio']; ?>
                                                    </span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <b>Relatante: </b> <?= $campos['relatante']; ?> <br>
                                                <b>Período: </b> <?= $campos['inicio']; ?> à <?= $campos['final']; ?><br>
                                                <b>Tempo de atendimento: </b> <?= $tempoAtendimento ?><br>
                                                <b>Privacidade: </b> <?php
                                                                        if ($private == 1) {
                                                                            echo "Público";
                                                                        } else {
                                                                            echo "Privado";
                                                                        };

                                                                        ?><br>
                                                <hr class="sidebar-divider">

                                                <b>Descrição: </b> <br><?= nl2br($campos['relato']); ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php $cont++;
                                }
                            } ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <div class="modal fade" id="relatoAvulso" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo relato avulso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card-body">
                            <form id="formRelatoAvulso" method="POST" action="processa/relatoAvulso.php">
                                <input readonly hidden id="relatoRelator" name="relatoRelator" value="<?= $uid ?>">
                                <input readonly hidden id="relatoAvulsoChamado" name="relatoAvulsoChamado" value="<?= $id_chamado ?>"></input>
                                <div class="col-12">
                                    <label for="relatoAvulso" class="form-label">Relato*</label>
                                    <textarea id="relatoAvulso" name="relatoAvulso" class="form-control" maxlength="10000" rows="8" required></textarea>
                                </div>
                                <hr class="sidebar-divider">
                                <div class="row">
                                    <div class="col-5">
                                    </div>
                                    <div class="col-4">
                                        <div id="buttonRelatoAvulsoLoading" style="display: none;">
                                            <div class="spinner-border text-success" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <button id="buttonRelatoAvulso" type="submit" class="btn btn-danger">Relatar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="basicModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo relato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card-body">
                            <form method="POST" id="relatarChamado" class="row g-3">
                                <span id="msgRelatar"></span>
                                <input readonly hidden id="chamadoID" name="chamadoID" value="<?= $id_chamado ?>"></input>
                                <input readonly hidden id="relatorID" name="relatorID" value="<?= $uid ?>"></input>
                                <input hidden id="startTime" name="startTime" value="<?= $chamado['in_execution_start']; ?>"></input>


                                <?php if (isset($chamado['prioridade'])) { ?>
                                    <input hidden readonly id="chamadoPrioridade" name="chamadoPrioridade" value="<?= $chamado['prioridade']; ?>"></input>
                                <?php } ?>

                                <style>
                                    .info-icon {
                                        color: red;
                                    }
                                </style>

                                <div class="col-4">
                                    <label for="statusChamado" class="form-label">Status*
                                        <?php
                                        if ($chamado['afericao_status'] == 1) { ?>
                                            <span class="bi bi-info-circle info-icon" data-bs-toggle="tooltip" title="Não é possivel fechar o chamado se tiver uma aferição pendente."></span>
                                        <?php } ?>
                                    </label>
                                    <select class="form-select" id="statusChamado" name="statusChamado">
                                        <option selected value="2">Andamento</option>
                                        <?php
                                        if ($chamado['afericao_status'] != 1 || $chamado['afericao_status'] === NULL) {
                                            echo '<option value="3">Fechado</option>';
                                        }
                                        $sql_status_chamados =
                                            "SELECT cs.id as id_status, cs.status_chamado as status_chamado
                                                    FROM chamados_status as cs
                                                    WHERE cs.active = 1 and cs.id != 1 and cs.id != 2 and cs.id != 3
                                                    ORDER BY cs.status_chamado ASC";
                                        $resultado = mysqli_query($mysqli, $sql_status_chamados);
                                        while ($status = mysqli_fetch_object($resultado)) :
                                            echo "<option value='$status->id_status'> $status->status_chamado</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <label for="privateChamado" class="form-label">Privacidade*</label>
                                    <select class="form-select" id="privateChamado" name="privateChamado">
                                        <option selected value="">Selecione</option>
                                        <option value='1'> Público</option>
                                        <option value='2'> Privado</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="novoRelato" class="form-label">Relato*</label>
                                    <textarea id="novoRelato" name="novoRelato" class="form-control" maxlength="10000" rows="8"></textarea>
                                </div>

                                <hr class="sidebar-divider">
                                <div class="row">
                                    <div class="col-5"></div>
                                    <div class="col-4">
                                        <span id="relatarLoading" hidden>
                                            <div class="spinner-border text-success" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </span>
                                        <input id="btnRelatar" name="btnRelatar" type="button" value="Relatar" class="btn btn-danger btn-sm"></input>
                                    </div>
                                    <div class="col-3">
                                        <a href="processa/cancelar_relato.php?idChamado=<?= $id_chamado ?>" class="btn btn-secondary btn-sm" onclick="confirmarCancelarRelato()">Cancelar Execução do Chamado</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalInteressados" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Interessados no Chamado</h5>
                        <div class="ml-auto">
                            <button type="button" class="btn btn-info rounded-circle position-absolute top-0 end-0 mt-3 me-5" data-bs-toggle="modal" data-bs-target="#modalAdicionarInteressados">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>E-mail</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lista_interessados =
                                                    "SELECT ci.id as 'id', ci.email as 'email'
                                                    FROM chamados_interessados as ci
                                                    WHERE ci.active = 1 and ci.chamado_id = $id_chamado
                                                    ORDER BY ci.email ASC";

                                                $r_lista_interessados = mysqli_query($mysqli, $lista_interessados);
                                                while ($c_lista_interessados = $r_lista_interessados->fetch_array()) { ?>
                                                    <tr>
                                                        <td><?= $c_lista_interessados['email']; ?></td>
                                                        <td style="text-align: left;">
                                                            <a href="processa/remove_interessado.php?id=<?= $c_lista_interessados['id'] ?>" onclick="return confirm('Deseja remover o interessado deste chamado?')" class="bi bi-dash-circle"></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
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

        <div class="modal fade" id="modalAdicionarInteressados" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Interessado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="processa/adicionar_interessado.php">
                            <input name="interessadosIdChamado" id="interessadosIdChamado" hidden readonly value="<?= $id_chamado ?>"></input>
                            <div class="col-8">
                                <label for="statusChamado" class="form-label">E-mail</label>
                                <input type="email" required placeholder="joao@gmail.com" name="interessadosEmail" id="interessadosEmail" class="form-control"></input>
                            </div>
                            <br>
                            <div class="col-12 text-center">
                                <button class="btn btn-danger" type="submit">Salvar</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEncaminhar" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Encaminhar Chamado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Usuário</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $lista_atendentes =
                                                    "SELECT u.id as idUsuario,
                                            p.nome as atendente
                                     FROM usuarios AS u
                                     LEFT JOIN pessoas AS p ON p.id = u.pessoa_id
                                     LEFT JOIN (
                                       SELECT cc.chamado_id, COUNT(cc.competencia_id) AS total_competencias
                                       FROM chamados_competencias AS cc
                                       GROUP BY cc.chamado_id
                                     ) AS comp_total ON comp_total.chamado_id = $id_chamado
                                     LEFT JOIN (
                                       SELECT cc.chamado_id, uc.id_usuario, COUNT(uc.id_competencia) AS total_competencias_usuario
                                       FROM chamados_competencias AS cc
                                       LEFT JOIN usuario_competencia AS uc ON cc.competencia_id = uc.id_competencia
                                       WHERE cc.chamado_id = $id_chamado
                                       GROUP BY cc.chamado_id, uc.id_usuario
                                     ) AS comp_usuario ON comp_usuario.chamado_id = $id_chamado AND comp_usuario.id_usuario = u.id
                                     WHERE (
                                       comp_total.chamado_id IS NULL
                                       OR comp_total.total_competencias = comp_usuario.total_competencias_usuario
                                     )
                                     and
                                     u.tipo_usuario = 1
                                     ORDER BY p.nome ASC;
                                     ";

                                                $r_lista_atendentes = mysqli_query($mysqli, $lista_atendentes);
                                                while ($c_lista_atendentes = $r_lista_atendentes->fetch_array()) { ?>
                                                    <tr>
                                                        <td><?= $c_lista_atendentes['atendente']; ?></td>
                                                        <td style="text-align: left;">
                                                            <a href="processa/encaminha.php?user=<?= $c_lista_atendentes['idUsuario'] ?>&chamado=<?= $id_chamado ?>" onclick="return confirm('Deseja encaminhar o chamado para este usuário?')" class="bi bi-arrow-left-right"></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
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

        <div class="modal fade" id="modalConfiguracoesChamados" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Configurações do Chamado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="processa/atualiza_confs_chamado.php">
                            <input readonly hidden value="<?= $id_chamado ?>" id="conf_id_chamado" name="conf_id_chamado"></input>
                            <div class="row">
                                <div class="col-8">
                                    <label for="conf_data_entrega" class="form-label">Data de Entrega</label>
                                    <input value="<?= isset($chamado['data_prevista_conclusao']) ? $chamado['data_prevista_conclusao'] : ''; ?>" id="conf_data_entrega" name="conf_data_entrega" type="datetime-local" class="form-control"></input>
                                </div>
                                <div class="col-4">
                                    <button style="margin-top: 38px;" type="submit" class="btn btn-danger btn-sm">Atualizar</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <form method="POST" action="processa/prioridade_chamado.php">
                            <input readonly hidden value="<?= $id_chamado ?>" id="conf_id_chamado" name="conf_id_chamado"></input>
                            <div class="row">
                                <div class="col-8">
                                    <label for="chamado_prioridade" class="form-label">Prioridade</label>
                                    <select class="form-select" name="chamado_prioridade" id="chamado_prioridade" required>
                                        <option selected disabled value="">Selecione</option>
                                        <?php
                                        // Insere as opções do select com as prioridades e chamados do banco de dados
                                        foreach ($chamados_prioridades as $chamado_pri) {
                                            echo "<option value=\"{$chamado_pri['prioridade']}\">#{$chamado_pri['prioridade']} - Chamado {$chamado_pri['id']}: {$chamado_pri['assuntoChamado']}</option>";
                                        }

                                        // Insere a próxima prioridade disponível
                                        echo "<option value=\"$proximo_numero\">#$proximo_numero - Disponivel</option>";
                                        ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <button style="margin-top: 38px;" type="submit" class="btn btn-danger btn-sm">Atualizar</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <form method="POST" action="processa/melhoria_recomendada.php">
                            <input readonly hidden value="<?= $id_chamado ?>" id="conf_id_chamado" name="conf_id_chamado"></input>
                            <div class="row">
                                <div class="col-8">
                                    <label for="chamado_melhoria_recomendada" class="form-label">Melhoria Recomendada</label>
                                    <select class="form-select" name="chamado_melhoria_recomendada" id="chamado_melhoria_recomendada" required>
                                        <option selected disabled value="">Selecione</option>

                                        <?php
                                        try {

                                            $stmt_melhoria_recomendada = $pdo->prepare("SELECT 
                                    pmc.id AS 'id_mc', 
                                    pmc.melhoria_conhecida AS 'mc',
                                    p.pop AS 'pop',
                                    COALESCE(c.id, NULL) AS 'id_chamado'
                                FROM 
                                    pop_melhorias_conhecidas AS pmc
                                LEFT JOIN
                                    pop AS p ON p.id = pmc.pop_id
                                LEFT JOIN
                                    chamados AS c ON c.melhoria_recomendada = pmc.id
                                WHERE 
                                    pmc.status = 1
                                ORDER BY
                                    p.pop ASC,
                                    pmc.melhoria_conhecida ASC;
                                ");
                                            $stmt_melhoria_recomendada->execute();

                                            $result_mr = $stmt_melhoria_recomendada->fetchAll(PDO::FETCH_ASSOC); ?>
                                            <?php
                                            if (count($result_mr) > 0) {
                                                foreach ($result_mr as $row_mr) {
                                                    $optionValue = $row_mr['id_mc'];
                                                    $optionText = $row_mr['pop'] . ' - ' . $row_mr['mc'];
                                                    $selected = ($chamado['melhoria_recomendada'] == $optionValue) ? 'selected' : '';


                                                    if ($row_mr['id_chamado'] !== null) {
                                                        $optionText .= ' (Chamado: ' . $row_mr['id_chamado'] . ')';
                                            ?>
                                                        <option disabled value="<?= $optionValue ?>" <?= $selected ?>><?= $optionText ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?= $optionValue ?>" <?= $selected ?>><?= $optionText ?></option>
                                                    <?php } ?>

                                        <?php }
                                            } else {
                                                echo '<option value="" disabled>Nenhuma melhoria recomendada encontrada.</option>';
                                            }
                                        } catch (PDOException $e) {
                                            echo "Erro na consulta: " . $e->getMessage();
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <button style="margin-top: 38px;" type="submit" class="btn btn-danger btn-sm">Atualizar</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <form method="POST" action="processa/alterar_tipo_chamado.php">
                            <input readonly hidden value="<?= $id_chamado ?>" id="conf_id_chamado" name="conf_id_chamado"></input>
                            <div class="row">
                                <div class="col-8">
                                    <label for="chamado_tipo_chamado" class="form-label">Tipo de Chamado</label>
                                    <select class="form-select" name="chamado_tipo_chamado" id="chamado_tipo_chamado" required>
                                        <option disabled value="">Selecione</option>
                                        <?php
                                        try {
                                            $query_tipos_chamados = $pdo->prepare(
                                                "SELECT id, tipo FROM tipos_chamados WHERE active = 1 ORDER BY tipo ASC"
                                            );
                                            $query_tipos_chamados->execute();
                                            $result_tc = $query_tipos_chamados->fetchAll(PDO::FETCH_ASSOC);
                                            if (count($result_tc) > 0) {
                                                foreach ($result_tc as $row_tc) {
                                                    $optionValue = $row_tc['id'];
                                                    $optionText = $row_tc['tipo'];
                                                    // Verifica se o tipo atual é igual ao tipo neste loop e marca a opção selecionada, se for o caso
                                                    $selected = ($optionValue == $chamado['tipo_id']) ? 'selected' : '';
                                                    echo "<option value='$optionValue' $selected>$optionText</option>";
                                                }
                                            } else {
                                                echo '<option value="" disabled>Nenhum tipo de chamado encontrado.</option>';
                                            }
                                        } catch (PDOException $e) {
                                            echo "Erro na consulta: " . $e->getMessage();
                                        }
                                        ?>
                                    </select>


                                </div>

                                <div class="col-4">
                                    <button style="margin-top: 38px;" type="submit" class="btn btn-danger btn-sm">Atualizar</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <form method="POST" action="processa/alterar_solicitante.php">
                            <input readonly hidden value="<?= $id_chamado ?>" id="conf_id_chamado" name="conf_id_chamado"></input>
                            <div class="row">
                                <div class="col-8">
                                    <label for="chamado_solicitante" class="form-label">Solicitante</label>
                                    <select class="form-select" name="chamado_solicitante" id="chamado_solicitante" required>
                                        <option disabled value="">Selecione</option>
                                        <?php
                                        try {
                                            $query_usuarios = $pdo->prepare(
                                                "SELECT u.id, p.nome FROM usuarios as u LEFT JOIN pessoas as p ON p.id = u.pessoa_id WHERE u.active = 1"
                                            );
                                            $query_usuarios->execute();
                                            $result_u = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);
                                            if (count($result_u) > 0) {
                                                foreach ($result_u as $row_u) {
                                                    $optionValue = $row_u['id'];
                                                    $optionText = $row_u['nome'];
                                                    // Verifica se o tipo atual é igual ao tipo neste loop e marca a opção selecionada, se for o caso
                                                    $selected = ($optionValue == $chamado['solicitante_id']) ? 'selected' : '';
                                                    echo "<option value='$optionValue' $selected>$optionText</option>";
                                                }
                                            } else {
                                                echo '<option value="" disabled>Nenhum usuário encontrado.</option>';
                                            }
                                        } catch (PDOException $e) {
                                            echo "Erro na consulta: " . $e->getMessage();
                                        }
                                        ?>
                                    </select>


                                </div>

                                <div class="col-4">
                                    <button style="margin-top: 38px;" type="submit" class="btn btn-danger btn-sm">Atualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAfericao" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>INFORMAÇÕES DA AFERIÇÃO</b></h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div class="modal-body">
                        <div class="col-12">
                            <div class="row">
                                <?php
                                $query_afericao = "SELECT * FROM afericao as a LEFT JOIN chamados as c ON c.id = a.chamado_id WHERE chamado_id = :chamado_id";

                                $stmt = $pdo->prepare($query_afericao);
                                $stmt->execute(array(':chamado_id' => $id_chamado));
                                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($resultados as $row) {
                                    $cto_id = $row['cto_id'];

                                    $relato_inicial = $row['relato_inicial'];
                                    $crm_pre_afericao = $row['crm_pre_afericao'];
                                    $crm_pos_afericao = $row['crm_pos_afericao'];
                                    $status = $row['status'];
                                    $relato = $row['relato'];
                                }
                                ?>

                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body" style="height: 700px; overflow-y: auto;">
                                            <br>
                                            <div>
                                                <strong>Relato Abertura</strong>
                                            </div>

                                            <br>
                                            <div>
                                                <?php echo nl2br($relato_inicial); ?>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body" style="height: 700px; overflow-y: auto;">
                                            <br>
                                            <div>
                                                <strong>Informações obtidas através do ERP - Antes Aferição</strong>
                                            </div>

                                            <br>
                                            <div>
                                                <?php echo nl2br($crm_pre_afericao); ?>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body" style="height: 500px; overflow-y: auto;">
                                            <br>

                                            <div class="col-12">
                                                <strong>Informações obtidas através do ERP - Depois Aferição</strong>
                                            </div>

                                            <div class="row">
                                                <div class="col-8">
                                                    <!-- Conteúdo do ERP -->
                                                    <?php echo nl2br($crm_pos_afericao); ?>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <form method="POST" action="processa/ler_dados_cto_erp.php">
                                                        <input readonly hidden id="cto_id" name="cto_id" value="<?= $cto_id ?>"></input>
                                                        <input readonly hidden id="chamado_id_cto" name="chamado_id_cto" value="<?= $id_chamado ?>"></input>

                                                        <button style="margin-top: 3px;" class="btn btn-sm btn-warning">Ler dados no ERP</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="card-body" style="height: 200px; overflow-y: auto;">
                                            <br>
                                            <div>

                                                <?php if ($status == 1) {

                                                    if (!empty($crm_pos_afericao)) {

                                                ?>
                                                        <form method="POST" action="processa/status_afericao.php">

                                                            <input id="chamado_id_update_status" name="chamado_id_update_status" hidden readonly value="<?= $id_chamado ?>">
                                                            <div class="12">
                                                                <textarea placeholder="Digite um relato" class="form-control" rows="2" style="resize: none;" id="relato_status" name="relato_status" required></textarea>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="col-12">
                                                                        <select class="form-select" name="status_afericao" id="status_afericao">
                                                                            <option value="1" <?php if ($status == 1) echo "selected"; ?>>Em análise</option>
                                                                            <option value="2" <?php if ($status == 2) echo "selected"; ?>>Negada</option>
                                                                            <option value="3" <?php if ($status == 3) echo "selected"; ?>>Realizada</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="col-6">
                                                                        <button style="margin-top: 3px;" class="btn btn-sm btn-danger">Alterar Status</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <?php } else { ?>
                                                        <div class="col-12 text-center">
                                                            <span><b><i> Realize primeiro a leitura de dados no ERP antes de alterar o status.</i></b></span>
                                                        </div>
                                                    <?php } ?>
                                                <?php } else { ?>

                                                    <div class="col-12">
                                                        <span>Status:
                                                            <?php
                                                            if ($status == 2) {
                                                                echo "Negada";
                                                            } elseif ($status == 3) {
                                                                echo "Realizada";
                                                            }
                                                            ?>
                                                        </span>

                                                        <div class="col-12">

                                                            <span> <textarea class="form-control" disabled rows="5" style="resize: none;"><?php echo nl2br($relato); ?></textarea>
                                                            </span>
                                                        </div>

                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <a href="/rede/ctos/visualizar.php?id=<?= $cto_id ?>" class="btn btn-sm btn-warning" target="_blank">Ir para CTO</a>

                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAnexos" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Anexos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <?php if ($chamado['status'] != "Fechado") { ?>
                            <form action="processa/upload.php" method="POST" id="uploadForm" enctype="multipart/form-data">
                                <input id="uploadChamadoID" name="uploadChamadoID" value="<?= $id_chamado ?>" hidden readonly></input>
                                <div class="col-lg-12 row">
                                    <div class="col-8">
                                        <input title="Permitido: jpg, jpeg, png, txt, pdf" required class="form-control" type="file" name="fileInput" id="fileInput" multiple>
                                    </div>
                                    <div class="col-4" style="margin-top: 5px;">
                                        <button class="btn btn-sm btn-danger" type="submit">Enviar</button>
                                    </div>
                                </div>
                            </form>
                        <?php }
                        $targetDirectory = '../../uploads/chamados/chamado' . $id_chamado . '/';

                        if (file_exists($targetDirectory)) {
                            $files = scandir($targetDirectory);
                            if ($files !== false) {
                                echo '<br><ul>';
                                foreach ($files as $file) {
                                    if ($file != '.' && $file != '..') {
                                        // Exiba os arquivos como links para download
                                        echo '<li><a href="' . $targetDirectory . $file . '" target="_blank">' . $file . '</a></li>';
                                    }
                                }
                                echo '</ul>';
                            } else {
                                echo '<br>Nenhum arquivo encontrado.';
                            }
                        } else {
                            echo '<br>Nenhum arquivo encontrado.';
                        } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalReabrirChamado" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>REABERTURA DE CHAMADO</b></h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div class="modal-body">
                        <div class="col-12">
                            <form method="POST" action="processa/reabertura_chamado.php">
                                <input id="reabertura_idChamado" name="reabertura_idChamado" value="<?= $id_chamado ?>" hidden readonly></input>
                                <div class="col-12">
                                    <textarea class="form-control" required id="text_reabertura" name="text_reabertura" rows="6" placeholder="Digite um relato de reabertura"></textarea>
                                </div>
                                <br>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-danger">Reabrir Chamado</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            // btn relatar
            $("#btnRelatar").click(function() {
                document.querySelector("#btnRelatar").hidden = true;
                document.querySelector("#relatarLoading").hidden = false;
                var dadosRelatar = $("#relatarChamado").serialize();

                $.post("/servicedesk/chamados/processa/newRelato.php", dadosRelatar, function(retornaRelatar) {

                    if (retornaRelatar.includes("Error")) {
                        $("#msgRelatar").slideDown('slow').html(retornaRelatar);
                        document.querySelector("#btnRelatar").hidden = false;
                        document.querySelector("#relatarLoading").hidden = true;
                        retirarMsgRelatar();
                    } else if (retornaRelatar.includes("Success")) {
                        var dadosIDChamado = document.querySelector("#chamadoID").value;

                        $.post("/notificacao/telegram/relato_chamado.php", {
                            id_chamado: dadosIDChamado
                        }, function(responseNotifyTelegram) {

                        });

                        // Enviar o comando POST para notify_mail.php
                        $.post("/notificacao/mail/relato_chamado.php", {
                            id_chamado: dadosIDChamado
                        }, function(responseNotifyMail) {
                            if (retornaRelatar.includes("Success")) {
                                $('#relatarChamado')[0].reset();
                                $("#basicModal").modal('hide');
                                recarregarPagina();
                            }
                        });
                    }
                });
            });

            function retirarMsgRelatar() {
                setTimeout(function() {
                    $("#msgRelatar").slideUp('slow', function() {});
                }, 1700);
            };
        </script>

        <script>
            function recarregarPagina() {
                location.reload();
            }
        </script>

        <script>
            // Função para remover os parâmetros 'success' e 'error' da URL
            function removeParameters() {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('success') || urlParams.has('error')) {
                    urlParams.delete('success');
                    urlParams.delete('error');
                    const newUrl = window.location.pathname + '?' + urlParams.toString();
                    history.replaceState({}, '', newUrl);
                }
            }

            // Chame a função quando a página for carregada
            window.addEventListener('load', removeParameters);
        </script>

        <script>
            function confirmarCancelarRelato() {
                if (confirm("Tem certeza que deseja cancelar a execução do chamado?")) {
                    // O usuário clicou em 'OK', prosseguir com o cancelamento do relato
                    return true;
                } else {
                    // O usuário clicou em 'Cancelar', cancelar a ação
                    return false;
                }
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('formRelatoAvulso').addEventListener('submit', function(event) {
                    // Impedir o envio do formulário
                    event.preventDefault();

                    // Esconder o botão Relatar
                    document.getElementById('buttonRelatoAvulso').style.display = 'none';

                    // Mostrar o spinner de carregamento
                    document.getElementById('buttonRelatoAvulsoLoading').style.display = 'block';

                    // Enviar o formulário
                    this.submit();
                });
            });
        </script>


<?php
    } else {
        require "../../acesso_negado.php";
    }
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>