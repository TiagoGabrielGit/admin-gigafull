<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "54";
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

    $user_info_query =
        "SELECT
        u.pessoa_id as pessoaID,
        u.tipo_usuario as tipoUsuario,
        u.empresa_id as empresa_id,
        e.atributoEmpresaPropria as atributoEmpresaPropria
        FROM usuarios as u
        LEFT JOIN empresas as e ON u.empresa_id = e.id
        WHERE u.id = :uid";

    $user_info_statement = $pdo->prepare($user_info_query);
    $user_info_statement->bindParam(':uid', $uid, PDO::PARAM_INT);
    $user_info_statement->execute();

    $user_info = $user_info_statement->fetch(PDO::FETCH_ASSOC);

    $permite_atender_chamados_outras_empresas = $_SESSION['permite_atender_chamados_outras_empresas'];
    $empresa_usuario = $_SESSION['empresa_id'];
    $atributoEmpresaPropria = $user_info['atributoEmpresaPropria'];
    $empresa_id = $_SESSION['empresa_id'];
    $equipe_id = $_SESSION['equipe_id'];

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {

        if (isset($_POST['empresaPesquisa'])) {
            if (!empty($_POST['empresaPesquisa'])) {
                $empresa_id = $_POST['empresaPesquisa'];
            } else {
                $empresa_id = "%";
            }
        } else {
            $empresa_id = "%";
        }


        if (isset($_POST['solicitantePesquisa'])) {
            if (!empty($_POST['solicitantePesquisa'])) {
                $solicitante_id = $_POST['solicitantePesquisa'];
            } else {
                $solicitante_id = "%";
            }
        } else {
            $solicitante_id = "%";
        }

        if (!empty($_POST['statusChamado'])) {
            $statusChamado = $_POST['statusChamado'];
        } else {
            $statusChamado = "LIKE '%'";
        }


        if (!empty($_POST['numChamadoPesquisa'])) {
            if ($_POST['numChamadoPesquisa'] == "") {
                $idChamado = "%";
            } else {
                $idChamado = $_POST['numChamadoPesquisa'];
            }
        } else {
            $idChamado = "%";
        }

        if (!empty($_POST['chamadoPesquisa'])) {
            if ($_POST['chamadoPesquisa'] == "") {
                $assuntoChamado = "%";
            } else {
                $assuntoChamado = $_POST['chamadoPesquisa'];
                $assuntoChamado = "%$assuntoChamado%";
            }
        } else {
            $assuntoChamado = "%";
        }

        if (!empty($_POST['relatoInicialPesquisa'])) {
            if ($_POST['relatoInicialPesquisa'] == "") {
                $relatoInicialPesquisa = "%";
            } else {
                $relatoInicialPesquisa = $_POST['relatoInicialPesquisa'];
                $relatoInicialPesquisa = "%$relatoInicialPesquisa%";
            }
        } else {
            $relatoInicialPesquisa = "%";
        }
    } else {
        $empresa_id = "%";
        $statusChamado = "LIKE '%'";
        $idChamado = "%";
        $assuntoChamado = "%";
        $solicitante_id = "%";
        $relatoInicialPesquisa = "%";
    }
?>

    <style>
        .btn-small {
            font-size: 12px;
            padding: 4px 8px;
        }

        .accordion-button:not(.collapsed) {
            color: #012970;
            background-color: #e6e6e6;
        }

        #closed:hover {
            cursor: pointer;
            background-color: #a9a9a9;
        }

        #open:hover {
            cursor: pointer;
            background-color: #c1f8f8;
        }

        #inExecution:hover {
            background-color: #7efb7e;
        }

        .closed {
            background-color: #c8c8c8;
            border-color: black;
        }

        .open {
            background-color: #ecfefe;
            border-color: black;
        }

        .inExecution {
            background-color: #a5fba5;
            border-color: black;
        }

        .colorAccordion {
            background-color: #ffffff;
            border-color: black;
        }
    </style>

    <?php if ($_SESSION['permite_atender_chamados'] == '1') { ?>

        <main id="main" class="main">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title" style="font-size: 28px;">FILTROS</h1>

                                <form method="POST" action="#" class="row g-3">
                                    <?php

                                    if ($permite_atender_chamados_outras_empresas == 1) {
                                        $sql_lista_empresas =
                                            "SELECT
                                        emp.id as id_empresa,
                                        emp.fantasia as fantasia_empresa
                                        FROM empresas as emp
                                        WHERE atributoCliente = '1' or atributoEmpresaPropria = '1'
                                        ORDER BY emp.fantasia ASC";
                                    } else if ($permite_atender_chamados_outras_empresas == 0) {
                                        $sql_lista_empresas =
                                            "SELECT
                                        emp.id as id_empresa,
                                        emp.fantasia as fantasia_empresa
                                        FROM empresas as emp
                                        WHERE atributoCliente = '1' and emp.id = $empresa_usuario or atributoEmpresaPropria = '1' and emp.id = $empresa_usuario
                                        ORDER BY emp.fantasia ASC";
                                    }



                                    if ($atributoEmpresaPropria == 1) { ?>
                                        <div class="col-lg-12 row">
                                            <div class="col-4">
                                                <label for="empresaPesquisa" class="form-label">Empresa</label>
                                                <select id="empresaPesquisa" name="empresaPesquisa" class="form-select">
                                                    <option selected value="%">Todas</option>
                                                    <?php
                                                    $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                                    while ($empresa = mysqli_fetch_object($resultado)) :
                                                        echo "<option value='$empresa->id_empresa'> $empresa->fantasia_empresa</option>";
                                                    endwhile;
                                                    if ($_SERVER["REQUEST_METHOD"] == 'POST') :
                                                    ?>
                                                        <script>
                                                            let nomeEmpresa = '<?= $_POST['empresaPesquisa']; ?>'
                                                            if (nomeEmpresa == '%') {} else {
                                                                document.querySelector("#empresaPesquisa").value = nomeEmpresa
                                                            }
                                                        </script>
                                                    <?php
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-4">
                                                <label for="solicitantePesquisa" class="form-label">Solicitante</label>
                                                <select id="solicitantePesquisa" name="solicitantePesquisa" class="form-select">
                                                    <option value="%">Todos</option>
                                                    <?php

                                                    $sql_lista_solicitantes =
                                                        "SELECT
                                                        u.id as solicitante_id,
                                                        p.nome as solicitante
                                                    FROM chamados as ch
                                                    LEFT JOIN usuarios as u ON ch.solicitante_id = u.id
                                                    LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                                    WHERE p.nome IS NOT NULL
                                                    GROUP BY ch.solicitante_id
                                                    order by p.nome ASC
                                                    ";


                                                    $resultado = mysqli_query($mysqli, $sql_lista_solicitantes);
                                                    while ($solicitante = mysqli_fetch_object($resultado)) {
                                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                            $solicitantePesquisa = $_POST['solicitantePesquisa'];
                                                        } else {
                                                            $solicitantePesquisa = "";
                                                        }
                                                        $selected = ($solicitantePesquisa == $solicitante->solicitante_id) ? 'selected' : '';
                                                        echo "<option value='$solicitante->solicitante_id' $selected> $solicitante->solicitante</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="col-lg-12 row">
                                        <div class="col-2">
                                            <label for="numChamadoPesquisa" class="form-label">Nº Chamado</label>
                                            <input name="numChamadoPesquisa" type="text" class="form-control" id="numChamadoPesquisa">

                                            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                                <script>
                                                    let numChamado = '<?= $_POST['numChamadoPesquisa']; ?>'
                                                    if (numChamado == '%') {} else {
                                                        document.querySelector("#numChamadoPesquisa").value = numChamado
                                                    }
                                                </script>
                                            <?php
                                            endif;
                                            ?>
                                        </div>

                                        <div class="col-4">
                                            <label for="chamadoPesquisa" class="form-label">Titulo Chamado</label>
                                            <input name="chamadoPesquisa" type="text" class="form-control" id="chamadoPesquisa">

                                            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                                <script>
                                                    let tituloChamado = '<?= $_POST['chamadoPesquisa']; ?>'
                                                    if (tituloChamado == '%') {} else {
                                                        document.querySelector("#chamadoPesquisa").value = tituloChamado
                                                    }
                                                </script>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                        <div class="col-4">
                                            <label for="relatoInicialPesquisa" class="form-label">Relato Inicial</label>
                                            <input name="relatoInicialPesquisa" type="text" class="form-control" id="relatoInicialPesquisa">

                                            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                                <script>
                                                    let relatoInicialChamado = '<?= $_POST['relatoInicialPesquisa']; ?>'
                                                    if (relatoInicialChamado == '%') {} else {
                                                        document.querySelector("#relatoInicialPesquisa").value = relatoInicialChamado
                                                    }
                                                </script>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <button style="margin-top: 30px; " type="submit" class="btn btn-sm btn-danger">Filtrar</button>
                                    </div>
                                </form>

                                <hr class="sidebar-divider">

                                <div class="accordion" id="accordionFlushExample">

                                    <?php if ($permite_atender_chamados_outras_empresas == 1) {
                                        // QUALQUER EMPRESA
                                        $chamados_query =
                                            "SELECT c.id as 'id_chamado',
                                            p.nome as 'solicitante_nome',
                                            pes.nome as 'atendente',
                                            c.in_execution as 'inExecution',
                                            c.status_id as id_status,
                                            c.data_prevista_conclusao as data_prevista_conclusao,
                                            c.melhoria_recomendada as melhoria_recomendada,
                                            c.relato_inicial as relato_inicial,
                                            date_format(c.data_abertura,'%H:%i:%s %d/%m/%Y') as dataAbertura,
                                            c.assuntoChamado as assunto,
                                            cs.status_chamado as statusChamado,
                                            tc.tipo as tipoChamado,
                                            e.fantasia as fantasia,
                                            s.service as service,
                                            ise.item as itemService
                                        FROM chamados c
                                        LEFT JOIN usuarios as u ON u.id = c.solicitante_id
                                        LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                        LEFT JOIN tipos_chamados as tc ON tc.id = c.tipochamado_id
                                        LEFT JOIN empresas as e ON e.id = c.empresa_id
                                        LEFT JOIN contract_service as cser ON  cser.id = c.service_id
                                        LEFT JOIN service as s ON s.id = cser.service_id 
                                        LEFT JOIN contract_iten_service as cis ON cis.id = c.iten_service_id
                                        LEFT JOIN iten_service as ise ON ise.id = cis.iten_service
                                        LEFT JOIN chamados_status as cs ON cs.id = c.status_id
                                        LEFT JOIN usuarios as us ON us.id = c.atendente_id
                                        LEFT JOIN pessoas as pes ON pes.id = us.pessoa_id
                                        INNER JOIN chamados_autorizados_atender caa ON c.tipochamado_id = caa.tipo_id
                                        WHERE caa.equipe_id = $equipe_id and c.status_id != 3 and (c.atendente_id = $uid or c.atendente_id is null)
                                        ORDER BY c.id desc";

                                        $stmt = $pdo->prepare($chamados_query);
                                    } else {
                                        // QUALQUER EMPRESA
                                        $chamados_query =
                                            "SELECT c.id as 'id_chamado',
                                            p.nome as 'solicitante_nome',
                                            pes.nome as 'atendente',
                                            c.in_execution as 'inExecution',
                                            c.status_id as id_status,
                                            c.data_prevista_conclusao as data_prevista_conclusao,
                                            c.melhoria_recomendada as melhoria_recomendada,
                                            c.relato_inicial as relato_inicial,
                                            date_format(c.data_abertura,'%H:%i:%s %d/%m/%Y') as dataAbertura,
                                            c.assuntoChamado as assunto,
                                            cs.status_chamado as statusChamado,
                                            tc.tipo as tipoChamado,
                                            e.fantasia as fantasia,
                                            s.service as service,
                                            ise.item as itemService
                                        FROM chamados c
                                        LEFT JOIN usuarios as u ON u.id = c.solicitante_id
                                        LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                        LEFT JOIN tipos_chamados as tc ON tc.id = c.tipochamado_id
                                        LEFT JOIN empresas as e ON e.id = c.empresa_id
                                        LEFT JOIN contract_service as cser ON  cser.id = c.service_id
                                        LEFT JOIN service as s ON s.id = cser.service_id 
                                        LEFT JOIN contract_iten_service as cis ON cis.id = c.iten_service_id
                                        LEFT JOIN iten_service as ise ON ise.id = cis.iten_service
                                        LEFT JOIN chamados_status as cs ON cs.id = c.status_id

                                        LEFT JOIN usuarios as us ON us.id = c.atendente_id
                                        LEFT JOIN pessoas as pes ON pes.id = us.pessoa_id
                                        INNER JOIN chamados_autorizados_atender caa ON c.tipochamado_id = caa.tipo_id
                                        WHERE caa.equipe_id = $equipe_id and e.id LIKE '$empresa_id' and c.status_id != 3  and (c.atendente_id = $uid or c.atendente_id is null)
                                        ORDER BY c.id desc";

                                        $stmt = $pdo->prepare($chamados_query);
                                    }

                                    $stmt->execute();


                                    $cont = '1';
                                    while ($campos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $id_chamado = $campos['id_chamado'];
                                        $solicitante_nome = $campos['solicitante_nome'];

                                        if (empty($campos['atendente'])) {
                                            $atendente = "Sem atendente";
                                        } else {
                                            $atendente = $campos['atendente'];
                                        }
                                        if ($campos['inExecution'] == 1) {
                                            $Color = "inExecution";
                                        } else if ($campos['id_status'] == 3) {
                                            $Color = "closed";
                                        } else {
                                            $Color = "open";
                                        }

                                        $currentDate = strtotime(date("Y-m-d H:i:s")); // Data atual em formato timestamp

                                        if ($campos['data_prevista_conclusao'] !== null) {
                                            $dataPrevistaConclusao = strtotime($campos['data_prevista_conclusao']); // Data prevista em formato timestamp
                                        } else {
                                        }


                                        if ($campos['data_prevista_conclusao'] === null) {
                                            $relogioColor = "green";
                                        } elseif ($dataPrevistaConclusao < $currentDate) {
                                            $colorPill = "danger";
                                            $relogioColor = "red";
                                        } elseif (($dataPrevistaConclusao - $currentDate) < 86400) {
                                            $colorPill = "warning";
                                            $relogioColor = "#FFC107";
                                        } else {
                                            $colorPill = "success";
                                            $relogioColor = "green";
                                        }


                                        $calc_tempo_total_query =
                                            "SELECT SUM(seconds_worked) as secondsTotal FROM chamados WHERE id = :id_chamado";
                                        $calc_tempo_total_statement = $pdo->prepare($calc_tempo_total_query);
                                        $calc_tempo_total_statement->bindParam(':id_chamado', $id_chamado, PDO::PARAM_INT);
                                        $calc_tempo_total_statement->execute();
                                        $res_second = $calc_tempo_total_statement->fetch(PDO::FETCH_ASSOC);

                                    ?>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading<?= $cont ?>">
                                                <button class="accordion-button collapsed <?= $Color ?>" id="<?= $Color ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">
                                                    <div class="d-flex justify-content-between align-items-center w-100">

                                                        <span class="text-left">
                                                            <?php if ($campos['id_status'] == 3 || $campos['data_prevista_conclusao'] === null) { ?>

                                                            <?php } else { ?>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?= $relogioColor ?>" class="bi bi-alarm" viewBox="0 0 16 16">
                                                                    <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z" />
                                                                    <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z" />
                                                                </svg> &nbsp;
                                                            <?php } ?>

                                                            <?php if ($campos['melhoria_recomendada'] === null) {
                                                            } else {
                                                                $melhoria_recomendada = $campos['melhoria_recomendada'];

                                                                $sql_melhoria = "SELECT pmc.melhoria_conhecida as 'melhoria', p.pop as pop FROM pop_melhorias_conhecidas as pmc LEFT JOIN pop as p ON p.id = pmc.pop_id WHERE pmc.id = :valor";
                                                                $stmt_melhoria = $pdo->prepare($sql_melhoria);
                                                                $stmt_melhoria->bindParam(':valor', $melhoria_recomendada);
                                                                $stmt_melhoria->execute();

                                                                $conteudo_coluna = $stmt_melhoria->fetch(PDO::FETCH_ASSOC);
                                                                $conteudo_tooltip =  $conteudo_coluna['pop'] . ' - ' . $conteudo_coluna['melhoria'];
                                                            ?>
                                                                <span title="Melhoria Recomendada: <?= $conteudo_tooltip ?>">

                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#9c7a16" class="bi bi-gem" viewBox="0 0 16 16">
                                                                        <path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.6l3-4zm11.386 3.785-1.806-2.41-.776 2.413 2.582-.003zm-3.633.004.961-2.989H4.186l.963 2.995 5.704-.006zM5.47 5.495 8 13.366l2.532-7.876-5.062.005zm-1.371-.999-.78-2.422-1.818 2.425 2.598-.003zM1.499 5.5l5.113 6.817-2.192-6.82L1.5 5.5zm7.889 6.817 5.123-6.83-2.928.002-2.195 6.828z" />
                                                                    </svg>
                                                                </span>
                                                                &nbsp;
                                                            <?php } ?>

                                                            <b>Chamado #<?= $id_chamado ?> - <?= $campos['tipoChamado']; ?> - <?= $campos['assunto']; ?></b><br>
                                                            Empresa: <?= $campos['fantasia']; ?><br>
                                                            Solicitante: <?= $solicitante_nome ?><br>
                                                            Atendente: <?= $atendente ?>
                                                            <br>
                                                            <?php if (isset($campos['prioridade']) && $atributoEmpresaPropria == 1) { ?>
                                                                <span class="badge bg-warning  text-dark">Prioridade: <?= $campos['prioridade'] ?></span>
                                                            <?php } ?>

                                                        </span>
                                                        <?php
                                                        $valida_competencia =
                                                            "SELECT cc.competencia_id as competencia_id
                                                    FROM chamados_competencias as cc
                                                    WHERE cc.chamado_id = $id_chamado
                                                    AND NOT EXISTS (
                                                    SELECT id_competencia
                                                    FROM usuario_competencia as uc
                                                    WHERE uc.id_usuario = $uid
                                                    AND uc.id_competencia = cc.competencia_id
                                                    )";
                                                        $r_valida_competencia = mysqli_query($mysqli, $valida_competencia);
                                                        $c_valida_competencia = $r_valida_competencia->fetch_assoc();

                                                        if ($atributoEmpresaPropria == 1) {
                                                            echo '<span class="text-end">';
                                                            if ($campos['data_prevista_conclusao'] === null || $campos['id_status'] == 3) {
                                                            } else { ?>
                                                                <span title="Data prevista de conclusão" class="btn btn-small btn-<?= $colorPill ?> rounded-pill"><?= date('d/m/Y H:i', strtotime($campos['data_prevista_conclusao'])) ?></span>
                                                        <?php }
                                                            if ($c_valida_competencia) {
                                                                // O usuário tem todas as competências necessárias
                                                                echo '<span class="btn btn-small btn-secondary rounded-pill">Qualificado</span>';
                                                            } else {
                                                                // O usuário não tem todas as competências necessárias
                                                                echo '<span class="text-end"><span class="btn btn-small btn-success rounded-pill">Qualificado</span>';
                                                            }
                                                            echo '</span>';
                                                        }
                                                        ?>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body colorAccordion">
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <div class="col-12">
                                                                <b>Chamado: </b><?= $id_chamado ?><br>
                                                                <b>Tipo de chamado: </b><?= $campos['tipoChamado']; ?><br>
                                                                <b>Cliente: </b><?= $campos['fantasia']; ?><br>
                                                                <b>Atendente: </b><?= $atendente ?><br><br>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <div class="col-12">
                                                                <b>Serviço: </b><?= $campos['service']; ?><br>
                                                                <b>Item de Serviço: </b><?= $campos['itemService']; ?><br>
                                                                <b>Data abertura: </b><?= $campos['dataAbertura']; ?><br>
                                                                <b>Status: </b><?= $campos['statusChamado']; ?><br><br>
                                                                <b>Tempo total atendimento: </b> <?= gmdate("H:i:s", $res_second['secondsTotal']); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="col-12">
                                                                <a href="/servicedesk/consultar_chamados/view.php?id=<?= $id_chamado ?>" title="Visualizar">
                                                                    <button type="button" class="btn btn-sm btn-danger">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                                        </svg>
                                                                        Ver chamado
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="sidebar-divider">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-12">
                                                                <b>Descrição: </b><br><?= nl2br($campos['relato_inicial']); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php $cont++;
                                    } ?>
                                </div>

                                <!-- End Table with stripped rows -->
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </main><!-- End #main -->
<?php } else {
        require "../../acesso_negado.php";
    }
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>