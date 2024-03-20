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
    $empresa_usuario = $_SESSION['empresa_id'];
    $equipe_id = $_SESSION['equipe_id'];


    if ($permite_interagir_chamados != 0) {

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            if (isset($_POST['atendentePesquisa'])) {
                if ($_POST['atendentePesquisa'] != '%') {
                    $atendentePesquisa = $_POST['atendentePesquisa'];
                } else {
                    $atendentePesquisa = "%";
                }
            } else {
                $atendentePesquisa = "%";
            }

            if ($atendentePesquisa === '0') {
                $whereAtendente = "AND ch.atendente_id = '0'";
            } else {
                $whereAtendente = "AND ch.atendente_id LIKE '$atendentePesquisa'";
            }


            if (isset($_POST['empresaPesquisa'])) {
                if (!empty($_POST['empresaPesquisa'])) {
                    $filtro_empresa = $_POST['empresaPesquisa'];
                } else {
                    $filtro_empresa = "%";
                }
            } else {
                $filtro_empresa = "%";
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


            if (isset($_POST['tipoChamadoPesquisa'])) {
                if (!empty($_POST['tipoChamadoPesquisa'])) {
                    $tipoChamadoPesquisa = $_POST['tipoChamadoPesquisa'];
                } else {
                    $tipoChamadoPesquisa = "%";
                }
            } else {
                $tipoChamadoPesquisa = "%";
            }
        } else {
            $whereAtendente = "AND ch.atendente_id LIKE '%'";
            $filtro_empresa = "%";
            $statusChamado = "LIKE '%'";
            $idChamado = "%";
            $assuntoChamado = "%";
            $solicitante_id = "%";
            $relatoInicialPesquisa = "%";
            $tipoChamadoPesquisa = "%";
        }

        if ($permite_interagir_chamados == 1) {
            //EMPRESA
            $chamados_query =
                "SELECT
            ch.id as id_chamado,
            ch.assuntoChamado as assunto,
            ch.relato_inicial as relato_inicial,
            ch.atendente_id as id_atendente,
            ch.chamado_dependente as chamado_dependente,
            ch.prioridade as prioridade,
            ch.melhoria_recomendada as melhoria_recomendada,
            date_format(ch.data_abertura,'%H:%i:%s %d/%m/%Y') as dataAbertura,
            ch.in_execution as inExecution,
            ch.status_id as id_status,
            ch.data_prevista_conclusao as 'data_prevista_conclusao',
            cs.status_chamado as statusChamado,
            cs.color as statusColor,
            tc.tipo as tipoChamado,
            emp.fantasia as fantasia,
            p.nome as atendente,
            s.service as service,
            ise.item as itemService,
                pes.nome as solicitante_nome,
                e.equipe as equipe_solicitante

            FROM chamados as ch
            LEFT JOIN empresas as emp ON ch.empresa_id = emp.id
            LEFT JOIN tipos_chamados as tc ON ch.tipochamado_id  = tc.id
            LEFT JOIN chamados_status as cs ON cs.id = ch.status_id
            LEFT JOIN usuarios as u ON u.id = ch.atendente_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            LEFT JOIN contract_service as cser ON  cser.id = ch.service_id
            LEFT JOIN service as s ON s.id = cser.service_id 
            LEFT JOIN contract_iten_service as cis ON cis.id = ch.iten_service_id
            LEFT JOIN iten_service as ise ON ise.id = cis.iten_service
            LEFT JOIN usuarios as us ON us.id = ch.solicitante_id
            LEFT JOIN pessoas as pes ON pes.id = us.pessoa_id
            LEFT JOIN equipe as e ON e.id = ch.solicitante_equipe_id
            LEFT JOIN chamados_autorizados_interagir AS cai ON cai.tipo_id = tc.id

                WHERE ch.empresa_id LIKE '$empresa_usuario'
                $whereAtendente
                AND ch.status_id $statusChamado
                AND ch.id LIKE '$idChamado'
                AND ch.assuntoChamado LIKE '$assuntoChamado'
                AND ch.relato_inicial LIKE '$relatoInicialPesquisa'
                AND ch.solicitante_id LIKE '$solicitante_id'
                AND cai.equipe_id = '$equipe_id'
                AND ch.tipochamado_id LIKE '$tipoChamadoPesquisa'
                ORDER BY ch.status_id = 3, IFNULL(ch.prioridade, 9999) ASC, ch.data_abertura DESC";

            $sql_lista_solicitantes =
                "SELECT
                    u.id as solicitante_id,
                    p.nome as solicitante
                    FROM chamados as ch
                    LEFT JOIN usuarios as u ON ch.solicitante_id = u.id
                    LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                    WHERE p.nome IS NOT NULL AND ch.empresa_id = $empresa_usuario
                    GROUP BY ch.solicitante_id
                    order by p.nome ASC
                    ";

            $sql_lista_atendentes =
                "SELECT
                CASE WHEN p.nome IS NULL THEN '0'             ELSE u.id END AS 'id',
                CASE WHEN p.nome IS NULL THEN 'Sem Atendente' ELSE p.nome END AS 'nome'
                FROM chamados as ch
                LEFT JOIN usuarios as u ON ch.atendente_id = u.id
                LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                WHERE p.nome IS NOT NULL AND ch.empresa_id = $empresa_usuario
                GROUP BY ch.atendente_id
                order by p.nome ASC";

            $sql_tipos_chamados =
                "SELECT
            u.id as solicitante_id,
            p.nome as solicitante
            FROM chamados as ch
            LEFT JOIN usuarios as u ON ch.solicitante_id = u.id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            WHERE ch.empresa_id = $empresa_usuario
            GROUP BY ch.solicitante_id
            order by p.nome ASC
            ";

            $sql_tipos_chamados =
                "SELECT
                tc.id as id_tipoChamado,
                tc.tipo as tipoChamado
                FROM chamados as ch
                LEFT JOIN tipos_chamados as tc ON tc.id = ch.tipochamado_id
                WHERE ch.empresa_id = $empresa_usuario
                GROUP BY ch.tipochamado_id
                order by tc.tipo ASC";
        } else if ($permite_interagir_chamados == 2) {
            //CHAMADOS ABERTOS POR SOLICITANTES DA EQUIPE
            $chamados_query =
                "SELECT
            ch.id as id_chamado,
            ch.assuntoChamado as assunto,
            ch.relato_inicial as relato_inicial,
            ch.atendente_id as id_atendente,
            ch.prioridade as prioridade,
            ch.chamado_dependente as chamado_dependente,

            ch.melhoria_recomendada as melhoria_recomendada,
            date_format(ch.data_abertura,'%H:%i:%s %d/%m/%Y') as dataAbertura,
            ch.in_execution as inExecution,
            ch.status_id as id_status,
            ch.data_prevista_conclusao as 'data_prevista_conclusao',
            cs.status_chamado as statusChamado,
            cs.color as statusColor,
            tc.tipo as tipoChamado,
            emp.fantasia as fantasia,
            p.nome as atendente,
            s.service as service,
            ise.item as itemService,
            pes.nome as solicitante_nome,
            e.equipe as equipe_solicitante

            FROM chamados as ch
            LEFT JOIN empresas as emp ON ch.empresa_id = emp.id
            LEFT JOIN tipos_chamados as tc ON ch.tipochamado_id  = tc.id
            LEFT JOIN chamados_status as cs ON cs.id = ch.status_id
            LEFT JOIN usuarios as u ON u.id = ch.atendente_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            LEFT JOIN contract_service as cser ON  cser.id = ch.service_id
            LEFT JOIN service as s ON s.id = cser.service_id 
            LEFT JOIN contract_iten_service as cis ON cis.id = ch.iten_service_id
            LEFT JOIN iten_service as ise ON ise.id = cis.iten_service
            LEFT JOIN usuarios as us ON us.id = ch.solicitante_id
            LEFT JOIN pessoas as pes ON pes.id = us.pessoa_id
            LEFT JOIN equipe as e ON e.id = ch.solicitante_equipe_id
            LEFT JOIN chamados_autorizados_interagir AS cai ON cai.tipo_id = tc.id
            LEFT JOIN chamados_autorizados_atender AS caa ON caa.tipo_id = tc.id

            WHERE 
            (ch.solicitante_equipe_id = :equipe_id OR caa.equipe_id = $equipe_id)
            and ch.empresa_id LIKE '$filtro_empresa'
            $whereAtendente
            and ch.status_id $statusChamado
            and ch.id LIKE '$idChamado'
            and ch.assuntoChamado LIKE '$assuntoChamado'
            AND ch.relato_inicial LIKE '$relatoInicialPesquisa'
            AND ch.solicitante_id LIKE '$solicitante_id'
            AND cai.equipe_id = '$equipe_id'
            AND ch.tipochamado_id LIKE '$tipoChamadoPesquisa'
            ORDER BY ch.status_id = 3, IFNULL(ch.prioridade, 9999) ASC, ch.data_abertura DESC";

            $sql_lista_solicitantes =
                "SELECT
                u.id as solicitante_id,
                p.nome as solicitante
                FROM chamados as ch
                LEFT JOIN usuarios as u ON ch.solicitante_id = u.id
                LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                WHERE p.nome IS NOT NULL AND ch.solicitante_equipe_id = $equipe_id
                GROUP BY ch.solicitante_id
                order by p.nome ASC";

            $sql_lista_atendentes =
                "SELECT
                CASE WHEN p.nome IS NULL THEN '0'             ELSE u.id END AS 'id',
                CASE WHEN p.nome IS NULL THEN 'Sem Atendente' ELSE p.nome END AS 'nome'
                FROM chamados as ch
                LEFT JOIN usuarios as u ON ch.atendente_id = u.id
                LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                WHERE p.nome IS NOT NULL AND ch.solicitante_equipe_id = $equipe_id
                GROUP BY ch.atendente_id
                order by p.nome ASC";

            $sql_tipos_chamados =
                "SELECT
                tc.id as id_tipoChamado,
                tc.tipo as tipoChamado
                FROM chamados as ch
                LEFT JOIN tipos_chamados as tc ON tc.id = ch.tipochamado_id
                WHERE ch.solicitante_equipe_id = $equipe_id
                GROUP BY ch.tipochamado_id
                order by tc.tipo ASC";
        } else if ($permite_interagir_chamados == 3) {
            //TODOS OS CHAMADOS
            $chamados_query =
                "SELECT
            ch.id as id_chamado,
            ch.assuntoChamado as assunto,
            ch.relato_inicial as relato_inicial,
            ch.atendente_id as id_atendente,
            ch.prioridade as prioridade,
            ch.chamado_dependente as chamado_dependente,

            ch.melhoria_recomendada as melhoria_recomendada,
            date_format(ch.data_abertura,'%H:%i:%s %d/%m/%Y') as dataAbertura,
            ch.in_execution as inExecution,
            ch.status_id as id_status,
            ch.data_prevista_conclusao as 'data_prevista_conclusao',
            cs.status_chamado as statusChamado,
            cs.color as statusColor,
            tc.tipo as tipoChamado,
            emp.fantasia as fantasia,
            p.nome as atendente,
            s.service as service,
            ise.item as itemService,
            pes.nome as solicitante_nome,
            e.equipe as equipe_solicitante
            FROM chamados as ch
            LEFT JOIN empresas as emp ON ch.empresa_id = emp.id
            LEFT JOIN tipos_chamados as tc ON ch.tipochamado_id  = tc.id
            LEFT JOIN chamados_status as cs ON cs.id = ch.status_id
            LEFT JOIN usuarios as u ON u.id = ch.atendente_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            LEFT JOIN contract_service as cser ON  cser.id = ch.service_id
            LEFT JOIN service as s ON s.id = cser.service_id 
            LEFT JOIN contract_iten_service as cis ON cis.id = ch.iten_service_id
            LEFT JOIN iten_service as ise ON ise.id = cis.iten_service
            LEFT JOIN usuarios as us ON us.id = ch.solicitante_id
            LEFT JOIN pessoas as pes ON pes.id = us.pessoa_id
            LEFT JOIN equipe as e ON e.id = ch.solicitante_equipe_id
            LEFT JOIN chamados_autorizados_interagir AS cai ON cai.tipo_id = tc.id

            WHERE ch.empresa_id LIKE '$filtro_empresa'
            $whereAtendente
            and ch.status_id $statusChamado
            and ch.id LIKE '$idChamado'
            AND ch.relato_inicial LIKE '$relatoInicialPesquisa'
            and ch.assuntoChamado LIKE '$assuntoChamado'
            AND ch.solicitante_id LIKE '$solicitante_id'
            AND cai.equipe_id = '$equipe_id'
            AND ch.tipochamado_id LIKE '$tipoChamadoPesquisa'
            ORDER BY ch.status_id = 3, IFNULL(ch.prioridade, 9999) ASC, ch.data_abertura DESC";

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

            $sql_lista_atendentes =
                "SELECT
                CASE WHEN p.nome IS NULL THEN '0'             ELSE u.id END AS 'id',
                CASE WHEN p.nome IS NULL THEN 'Sem Atendente' ELSE p.nome END AS 'nome'
                FROM chamados as ch
                LEFT JOIN usuarios as u ON ch.atendente_id = u.id
                LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                WHERE p.nome IS NOT NULL
                GROUP BY ch.atendente_id
                order by p.nome ASC";

            $sql_tipos_chamados =
                "SELECT
                    tc.id as id_tipoChamado,
                    tc.tipo as tipoChamado
                    FROM chamados as ch
                    LEFT JOIN tipos_chamados as tc ON tc.id = ch.tipochamado_id
                    GROUP BY ch.tipochamado_id
                    order by tc.tipo ASC";
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

        <main id="main" class="main">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h1 class="card-title" style="font-size: 28px;">FILTROS</h1>
                                    </div>
                                    <div class="col-3">
                                        <a href="/servicedesk/novo_chamado/index.php" style="margin-top: 20px;" class="btn btn-sm btn-danger">Abrir Chamado</a>
                                    </div>
                                </div>
                                <form method="POST" action="#" class="row g-3">
                                    <?php

                                    if ($permite_interagir_chamados == 1 || $permite_interagir_chamados == 2) {
                                        $sql_lista_empresas =
                                            "SELECT
                                        e.id as id_empresa,
                                        e.fantasia as fantasia_empresa
                                        FROM empresas as e
                                        WHERE e.id = $empresa_usuario
                                        ORDER BY e.fantasia ASC
                                        ";
                                    } else if ($permite_interagir_chamados == 3) {
                                        $sql_lista_empresas =
                                            "SELECT
                                        emp.id as id_empresa,
                                        emp.fantasia as fantasia_empresa
                                        FROM empresas as emp
                                        ORDER BY emp.fantasia ASC
                                        ";
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
                                                    $resultado_solicitantes = mysqli_query($mysqli, $sql_lista_solicitantes);
                                                    while ($solicitante = mysqli_fetch_object($resultado_solicitantes)) {
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

                                            <div class="col-4">

                                                <label for="atendentePesquisa" class="form-label">Atendente</label>
                                                <select id="atendentePesquisa" name="atendentePesquisa" class="form-select">
                                                    <option value="%">Todos</option>
                                                    <?php

                                                    $resultado = mysqli_query($mysqli, $sql_lista_atendentes);
                                                    while ($atendente = mysqli_fetch_object($resultado)) {
                                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                            $atdPesquisa = $_POST['atendentePesquisa'];
                                                        } else {
                                                            $atdPesquisa = "";
                                                        }
                                                        $selected = ($atdPesquisa == $atendente->id) ? 'selected' : '';
                                                        echo "<option value='$atendente->id' $selected> $atendente->nome</option>";
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

                                        <div class="col-3">
                                            <label for="statusChamado" class="form-label">Status</label>
                                            <select id="statusChamado" name="statusChamado" class="form-select">

                                                <option selected value="LIKE '%'">Todos</option>
                                                <?php

                                                $sql_status_chamados =
                                                    "SELECT
                                            cs.id as 'id',
                                            cs.status_chamado as 'status'
                                            FROM
                                            chamados_status as cs
                                            WHERE
                                            cs.active = 1
                                            order by
                                            cs.status_chamado ASC";

                                                $resultado = mysqli_query($mysqli, $sql_status_chamados);
                                                while ($status = mysqli_fetch_object($resultado)) :
                                                    echo "<option value='LIKE $status->id'> $status->status</option>";
                                                endwhile;
                                                ?>
                                                <option value="!= 3">Não Fechados</option>
                                                <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                                    <script>
                                                        let statusChamado = '<?= $_POST['statusChamado']; ?>'
                                                        if (statusChamado.includes("LIKE '%")) {} else {
                                                            document.querySelector("#statusChamado").value = statusChamado
                                                        }
                                                    </script>
                                                <?php
                                                endif;
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-3">
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


                                    <div class="col-lg-12 row">
                                        <div class="col-4">
                                            <label for="tipoChamadoPesquisa" class="form-label">Tipo de Chamado</label>
                                            <select id="tipoChamadoPesquisa" name="tipoChamadoPesquisa" class="form-select">
                                                <option value="%">Todos</option>
                                                <?php
                                                $r_tipos_chamados = mysqli_query($mysqli, $sql_tipos_chamados);
                                                while ($tipos_chamados = mysqli_fetch_object($r_tipos_chamados)) {
                                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                        $tipoChamadoPesquisa = $_POST['tipoChamadoPesquisa'];
                                                    } else {
                                                        $tipoChamadoPesquisa = "";
                                                    }
                                                    $selected = ($tipoChamadoPesquisa == $tipos_chamados->id_tipoChamado) ? 'selected' : '';
                                                    echo "<option value='$tipos_chamados->id_tipoChamado' $selected> $tipos_chamados->tipoChamado</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div class="text-center">
                                            <button style="margin-top: 30px; " type="submit" class="btn btn-sm btn-danger">Aplicar Filtros</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="accordion" id="accordionFlushExample">

                                    <?php if ($permite_interagir_chamados == 1) {
                                        $stmt = $pdo->prepare($chamados_query);
                                        $stmt->execute();
                                    } else if ($permite_interagir_chamados == 2) {
                                        $stmt = $pdo->prepare($chamados_query);
                                        $stmt->execute(array('equipe_id' => $equipe_id));
                                    } else if ($permite_interagir_chamados == 3) {
                                        $stmt = $pdo->prepare($chamados_query);
                                        $stmt->execute();
                                    }

                                    $cont = '1';
                                    echo "<br>";
                                    while ($campos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $id_chamado = $campos['id_chamado'];
                                        $solicitante_nome = $campos['solicitante_nome'];
                                        $equipe_solicitante = $campos['equipe_solicitante'];

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
                                            // Restante do seu código que utiliza $timestamp
                                        } else {
                                            // Lógica para lidar com o caso em que $datetime é nulo
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
                                                            Solicitante: <?= $solicitante_nome . ' (Equipe: ' . $equipe_solicitante . ')'  ?><br>
                                                            Atendente: <?= $atendente ?>
                                                            <br>
                                                            <?php if (isset($campos['prioridade']) && $atributoEmpresaPropria == 1) { ?>
                                                                <span class="badge bg-warning  text-dark">Prioridade: <?= $campos['prioridade'] ?></span>
                                                            <?php } ?>

                                                        </span>

                                                        <span class="text-end">
                                                            <?php
                                                            if ($atributoEmpresaPropria == 1) {
                                                                if ($campos['data_prevista_conclusao'] === null || $campos['id_status'] == 3) {
                                                                } else { ?>
                                                                    <span title="Data prevista de conclusão" class="btn btn-small btn-<?= $colorPill ?> rounded-pill"><?= date('d/m/Y H:i', strtotime($campos['data_prevista_conclusao'])) ?></span>
                                                                <?php }
                                                                if ($campos['chamado_dependente'] === null || $campos['chamado_dependente'] == 0) {
                                                                } else { ?>
                                                                    <a href="/servicedesk/chamados/visualizar_chamado.php?id=<?= $campos['chamado_dependente'] ?>" target="_blank">
                                                                        <span style="margin-top: 10px;" class="btn btn-small btn-warning rounded-pill">Dependente do chamado <?= $campos['chamado_dependente'] ?></span>
                                                                    </a>
                                                                <?php } ?>
                                                                <br>
                                                            <?php } ?>
                                                            <br>
                                                            <span style="margin-top: 10px; color: #FFFFFF; background-color: <?= $campos['statusColor'] ?>;" class="badge">Status: <?= $campos['statusChamado'] ?></span>


                                                        </span>
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
                                                                <a href="/servicedesk/chamados/visualizar_chamado.php?id=<?= $id_chamado ?>" title="Visualizar">
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

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
<?php
    } else {
        require "../../acesso_negado.php";
    }
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>