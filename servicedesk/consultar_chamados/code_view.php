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

<?php
if ($chamado['in_execution'] == 1) {
    $classeColor = "playColor";
} else {
    $classeColor = "";
}

$currentDate = strtotime(date("Y-m-d H:i:s")); // Data atual em formato timestamp
$dataPrevistaConclusao = strtotime($chamado['data_prevista_conclusao']); // Data prevista em formato timestamp


if ($chamado['data_prevista_conclusao'] === null) {
} elseif ($dataPrevistaConclusao < $currentDate) {
    $colorPill = "danger";
} elseif (($dataPrevistaConclusao - $currentDate) < 86400) {
    $colorPill = "Warning";
} else {
    $colorPill = "success";
} ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chamado #<?= $id_chamado ?></h1>
    </div>

    <?php
    if (isset($_GET['success'])) {
        $successMessage = $_GET['success'];

        if ($successMessage == 1) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo 'Cancelado execução de chamado e realizado exclusão de rascunho de relato.';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
        }

        if ($successMessage == 2) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo 'Cancelada execução de chamado. Nenhum rascunho de chamado encontrado.';
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
                    <div class="col-lg-3">
                        <a href="index.php">
                            <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                Listagem Chamados
                            </button>
                        </a>
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

                                <b>Empresa:</b> <?= $chamado['empresa']; ?> <br>
                                <b>Solicitante:</b> <?= $solicitante['solicitante']; ?><br>
                                <b>Atendente:</b> <?= $atendente ?><br>
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
                                    WHERE uc.id_usuario = $id_usuario
                                    AND uc.id_competencia = cc.competencia_id)";

                        $r_valida_competencia = mysqli_query($mysqli, $valida_competencia);
                        $r_valida_competencia2 = mysqli_query($mysqli, $valida_competencia);
                        $c_valida_competencia = $r_valida_competencia->fetch_array();
                        $c_valida_competencia2 = $r_valida_competencia2->fetch_array();

                        ?>

                        <div class="col-lg-4 text-center">

                            <div class="row">
                                <div class="col-12 " style="margin-top: 5px;">
                                    <?php
                                    if ($c_valida_competencia == null && $id_usuario != $chamado['id_atendente'] && $chamado['status'] != "Fechado") {
                                        if ($chamado['in_execution'] == '0' && $_SESSION['permissao_apropriar_chamado'] == 1) {
                                    ?>
                                            <a href="processa/apropriar.php?id=<?= $id_chamado  ?>&pessoa=<?= $id_usuario ?> "><button title="Apropriar" type="button" class="btn btn-info"><i class="bi bi-pin"></i></button></a>
                                        <?php } ?>

                                        <button title="Inserir um relato" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#relatoAvulso"><i class="bi bi-pencil-square"></i></button>

                                    <?php } else if ($id_usuario == $chamado['id_atendente'] && $chamado['in_execution'] == '1' && $chamado['in_execution_atd_id'] == $idPessoa) { ?>

                                        <button title="Inserir um relato" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#basicModal"><i class="bi bi-pencil-square"></i></button>

                                    <?php } else if ($c_usuario_ocupado['qtde'] == '0' && $id_usuario == $chamado['id_atendente'] && $chamado['in_execution'] == '0' && $chamado['status'] != "Fechado") { ?>
                                        <a href=" processa/executar.php?id=<?= $id_chamado ?>&pessoa=<?= $idPessoa ?> "><button title=" Executar chamado" type="button" class="btn btn-success"><i class="bi bi-file-play"></i></button></a>
                                    <?php } ?>

                                    <?php
                                    if ($chamado['status'] != "Fechado" &&  $chamado['in_execution'] == '0' && $_SESSION['permissao_encaminhar_chamado'] == 1) { ?>
                                        <button title="Encaminhar Chamado" type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalEncaminhar"><i class="bi bi-arrow-left-right"></i></button>
                                    <?php }

                                    if ($chamado['status'] != "Fechado" && $_SESSION['permissao_interessados_chamados'] == 1) { ?>
                                        <button title="Interessados no chamado" type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalInteressados"><i class="bi bi-people"></i></button>
                                    <?php } ?>



                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 " style="margin-top: 5px;">

                                    <?php if ($chamado['status'] != "Fechado" && $_SESSION['permissao_configuracoes_chamados'] == 1) { ?>
                                        <button title="Configurações do Chamado" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalConfiguracoesChamados"><i class="bi bi-gear"></i></button>
                                    <?php } ?>

                                    <?php if ($c_valida_competencia == null) { ?>
                                        <button title="Qualificado para atender" type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalQualificacao"><i class="bi bi-award"></i></button>
                                    <?php } else { ?>
                                        <button title="Não qualificado para atender" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalQualificacao"><i class="bi bi-award"></i></button>
                                    <?php  }
                                    ?>
                                    <button title="Gerar relatório do chamado" type="button" class="btn btn-info">
                                        <a href="/tcpdf/export/relatorio_chamados.php?id=<?= $id_chamado ?>" target="_blank">
                                            <i class="bi bi-cloud-download"></i>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="col-lg-12">
                            <div class="col-12">
                                <b>Descrição: </b><br><?= nl2br($chamado['relato_inicial']); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="relatoAvulso" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Novo relato avulso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="card-body">
                                    <form method="POST" action="processa/relatoAvulso.php">
                                        <input readonly hidden id="relatoRelator" name="relatoRelator" value="<?= $id_usuario ?>">
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
                                                <button type="submit" class="btn btn-danger">Relatar</button>
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
                                    <!--<form method="POST" action="processa/newRelato.php" class="row g-3 needs-validation">-->
                                    <form method="POST" id="relatarChamado" class="row g-3">
                                        <span id="msgSalvaRascunhoRelato"></span>
                                        <span id="msgRelatar"></span>
                                        <input readonly hidden id="chamadoID" name="chamadoID" value="<?= $id_chamado ?>"></input>
                                        <input readonly hidden id="tipoUsuario" name="tipoUsuario" value="<?= $tipoUsuario ?>"></input>
                                        <input readonly hidden id="relatorID" name="relatorID" value="<?= $id_usuario ?>"></input>
                                        <input hidden id="startTime" name="startTime" value="<?= $chamado['in_execution_start']; ?>"></input>


                                        <?php if (isset($chamado['prioridade'])) { ?>
                                            <input hidden readonly id="chamadoPrioridade" name="chamadoPrioridade" value="<?= $chamado['prioridade']; ?>"></input>
                                        <?php } ?>
                                        <div class="col-4">
                                            <label for="statusChamado" class="form-label">Status*</label>
                                            <select class="form-select" id="statusChamado" name="statusChamado">
                                                <option selected value="2">Andamento</option>
                                                <?php
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

                <hr class="sidebar-divider">

                <div class="accordion" id="accordionFlushExample">
                    <?php
                    $resultado_relatos = mysqli_query($mysqli, $sql_relatos)  or die("Erro ao retornar dados");
                    $cont = 1;
                    while ($campos = $resultado_relatos->fetch_array()) {
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
                    } ?>
                </div>
            </div>
        </div>
    </section>
</main>


<?php
$competencias_necessarias =
    "SELECT
cc.competencia_id as competencia_id, 
c.competencia as competencia,
c.descricao as descricao
FROM
chamados_competencias as cc
LEFT JOIN
competencias as c
ON
c.id = cc.competencia_id
WHERE
cc.chamado_id = $id_chamado
ORDER BY
c.competencia ASC";
$r_competencias_necessarias = mysqli_query($mysqli, $competencias_necessarias);
$r_competencias_necessarias2 = mysqli_query($mysqli, $competencias_necessarias);

?>

<div class="modal fade" id="modalQualificacao" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Competências Necessárias</h5>
                <div class="ml-auto">
                    <?php if ($_SESSION['permissao_selecionar_competencias'] == 1) { ?>

                        <button type="button" class="btn btn-info rounded-circle position-absolute top-0 end-0 mt-3 me-5" data-bs-toggle="modal" data-bs-target="#modalAdicionarQualificacao">
                            <i class="bi bi-plus"></i>
                        </button>
                    <?php } ?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="row mb-4">

                        <?php while ($c_competencias_necessarias = mysqli_fetch_assoc($r_competencias_necessarias)) {
                            $idCompetencia = $c_competencias_necessarias['competencia_id'];

                            $consulta_competencia_usuario =
                                "SELECT
                                uc.id
                                FROM
                                usuario_competencia as uc
                                WHERE
                                uc.id_usuario = $id_usuario
                                and
                                uc.id_competencia = $idCompetencia";

                            $r_consulta_competencia_usuario = mysqli_query($mysqli, $consulta_competencia_usuario);
                            $c_consulta_competencia_usuario = mysqli_fetch_assoc($r_consulta_competencia_usuario);

                            if ($c_consulta_competencia_usuario) { ?>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 5px" type="button" class="btn btn-success col-12" data-bs-toggle="modal" data-bs-target="#modalDetalhesCompetencia<?= $idCompetencia ?>">

                                            <?= $c_competencias_necessarias['competencia'] ?>
                                        </button>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 5px" type="button" class="btn btn-secondary col-12" data-bs-toggle="modal" data-bs-target="#modalDetalhesCompetencia<?= $idCompetencia ?>">
                                            <?= $c_competencias_necessarias['competencia'] ?>
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php while ($c_competencias_necessarias2 = mysqli_fetch_assoc($r_competencias_necessarias2)) {
    $idCompetencia2 = $c_competencias_necessarias2['competencia_id']; ?>
    <div class="modal fade" id="modalDetalhesCompetencia<?= $idCompetencia2 ?>" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $c_competencias_necessarias2['competencia'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= $c_competencias_necessarias2['descricao'] ?>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>


<div class="modal fade" id="modalAdicionarQualificacao" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Compentência</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Competência</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $adicionar_competencia =
                            "SELECT 
                            c.competencia as competencia,
                            c.id as idCompetencia
                            FROM competencias AS c
                            WHERE c.id NOT IN (
                            SELECT cc.competencia_id
                            FROM chamados_competencias AS cc
                            WHERE cc.chamado_id = 71
                            )
                            and c.active = 1
                            ORDER BY
                            c.competencia ASC
                            ";
                        $r_adicionar_competencia = mysqli_query($mysqli, $adicionar_competencia);
                        while ($c_adicionar_competencia = $r_adicionar_competencia->fetch_array()) { ?>
                            <tr>
                                <td><?= $c_adicionar_competencia['competencia']; ?></td>
                                <td style="text-align: left;">
                                    <a href="processa/addCompetencia.php?competencia=<?= $c_adicionar_competencia['idCompetencia'] ?>&chamado=<?= $id_chamado ?>" onclick="return confirm('Deseja atribuir esta competência ao chamado?')" class="bi bi-arrow-left-right"></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
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
                                            "SELECT
                                        ci.id as 'id',
                                        ci.email as 'email'
                                        FROM
                                        chamados_interessados as ci
                                        WHERE
                                        ci.active = 1
                                        and
                                        ci.chamado_id = $id_chamado
                                        ORDER BY
                                        ci.email ASC
                                        ";

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

<?php
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Busca os chamados com suas prioridades
    $sql_prioridades_chamados = "SELECT id, prioridade, assuntoChamado FROM chamados where prioridade IS NOT NULL and status_id <> 3 ORDER BY prioridade";
    $stmt_prioridades_chamados = $pdo->query($sql_prioridades_chamados);
    $chamados_prioridades = $stmt_prioridades_chamados->fetchAll(PDO::FETCH_ASSOC);

    // Encontra a próxima prioridade disponível
    $proximo_numero = 1;
    foreach ($chamados_prioridades as $chamado_pri) {
        if ($chamado_pri['prioridade'] == $proximo_numero) {
            $proximo_numero++;
        } else {
            break;
        }
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

?>


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
            </div>
            <div class="modal-footer">

            </div>

        </div>
    </div>
</div>

<?php
require "scripts/js_smart.php";
require "../../includes/footer.php";
?>