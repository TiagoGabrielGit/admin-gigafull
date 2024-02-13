<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "50";
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
    $s_empresaID = $_SESSION['empresa_id'];
    $permissao_abrir_chamado = $_SESSION['permissao_abrir_chamado'];
    $chamados_permitidos_abertura = $_SESSION['chamados_permitidos_abertura'];

    if ($permissao_abrir_chamado == 1) {
        $sql_lista_empresas =
            "SELECT
        emp.id as id_empresa,
        emp.fantasia as fantasia_empresa
        FROM
        empresas as emp
        WHERE
        atributoCliente = '1'
        or
        atributoEmpresaPropria = '1'
        ORDER BY
        emp.fantasia ASC
        ";
    } else if ($permissao_abrir_chamado == 0) {
        $sql_lista_empresas =
            "SELECT emp.id as id_empresa, emp.fantasia as fantasia_empresa
        FROM empresas as emp
        WHERE atributoCliente = '1' and emp.id = $s_empresaID or atributoEmpresaPropria = '1' and emp.id = $s_empresaID
        ORDER BY emp.fantasia ASC";
    } ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Abertura de Chamado</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="formAbrirChamado" action="/servicedesk/novo_chamado/processa/add.php" method="POST"
                                class="row g-3">

                                <span id="msg"></span>

                                <input hidden id="solicitante" name="solicitante" value="<?= $uid ?>"></input>

                                <div class="col-6">
                                    <label for="empresaChamado" class="form-label">Empresa*</label>
                                    <select class="form-select" id="empresaChamado" name="empresaChamado" required>
                                        <option disabled selected value="">Selecione a empresa</option>
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                        while ($tipos = mysqli_fetch_object($resultado)):
                                            echo "<option value='$tipos->id_empresa'> $tipos->fantasia_empresa</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="tipoChamado" class="form-label">Tipo de chamado*</label>
                                    <select class="form-select" id="tipoChamado" name="tipoChamado" required>
                                        <option disabled selected value="">Selecione o tipo de chamado</option>
                                        <?php

                                        if ($chamados_permitidos_abertura == 1) {
                                            $lista_tipos_chamados =
                                                "SELECT tc.id as idTipo,  tc.tipo as tipoChamado, tc.permite_data_entrega as 'permite_data_entrega', tc.horas_prazo_entrega as 'horas_prazo_entrega'
                                                FROM tipos_chamados as tc
                                                LEFT JOIN chamados_autorizados_by_equipe as cae ON tc.id = cae.tipo_id
                                                LEFT JOIN chamados_autorizados_by_company as cac ON tc.id = cac.tipo_id
                                                WHERE tc.afericao != '1' and tc.active = 1 and cac.company_id = $s_empresaID
                                                GROUP BY  tc.id 
                                                ORDER BY tc.tipo ASC";

                                        } else if ($chamados_permitidos_abertura == 2) {
                                            $lista_tipos_chamados =
                                                "SELECT tc.id as idTipo, tc.tipo as tipoChamado, tc.permite_data_entrega as 'permite_data_entrega', tc.horas_prazo_entrega as 'horas_prazo_entrega'
                                                FROM tipos_chamados as tc
                                                LEFT JOIN chamados_autorizados_by_equipe as cae ON tc.id = cae.tipo_id
                                                LEFT JOIN chamados_autorizados_by_company as cac ON tc.id = cac.tipo_id
                                                WHERE tc.afericao != '1' and tc.active = 1 and cae.equipe_id IN 
                                                (SELECT ei.equipe_id as idEquipe 
                                                FROM equipes_integrantes as ei
                                                WHERE ei.integrante_id = $uid)
                                                GROUP BY tc.id
                                                ORDER BY tc.tipo ASC";

                                        } else if ($chamados_permitidos_abertura == 3) {
                                            $lista_tipos_chamados =
                                                "SELECT tc.id as idTipo, tc.tipo as tipoChamado, tc.permite_data_entrega as 'permite_data_entrega', tc.horas_prazo_entrega as 'horas_prazo_entrega'
                                                FROM tipos_chamados as tc
                                                LEFT JOIN chamados_autorizados_by_equipe as cae ON tc.id = cae.tipo_id
                                                LEFT JOIN chamados_autorizados_by_company as cac ON tc.id = cac.tipo_id
                                                WHERE tc.afericao != '1' and  tc.active = 1 and cae.equipe_id IN 
                                                (SELECT ei.equipe_id as idEquipe
                                                FROM equipes_integrantes as ei
                                                WHERE ei.integrante_id = $uid) OR tc.active = 1 and cac.company_id = $s_empresaID
                                                GROUP BY tc.id
                                                ORDER BY tc.tipo ASC";
                                        }
                                        $r_lista_tipos_chamados = mysqli_query($mysqli, $lista_tipos_chamados);

                                        while ($tipos_chamados = mysqli_fetch_object($r_lista_tipos_chamados)) {
                                            $permite_data_entrega = $tipos_chamados->permite_data_entrega;
                                            $data_permitida = $permite_data_entrega ? '1' : '0';
                                            $horas_prazo_entrega = $tipos_chamados->horas_prazo_entrega;

                                            echo "<option value='$tipos_chamados->idTipo' data-permite-data-entrega='$data_permitida' data-horas-prazo-entrega='$horas_prazo_entrega' data-nao-permite-atendente>$tipos_chamados->tipoChamado</option>";


                                            if ($tipos_chamados->permite_data_entrega == 1) {
                                                $data_minima = date('Y-m-d H:i', strtotime("+ $horas_prazo_entrega hours"));
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="selectService" class="form-label">Serviço*</label>
                                    <select class="form-select" id="selectService" name="selectService" required>
                                        <option disabled selected value="">Selecione a Empresa</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="selectIten" class="form-label">Item de Serviço</label>
                                    <select class="form-select" id="selectIten" name="selectIten">
                                        <option disabled selected value="">Selecione um serviço</option>
                                    </select>
                                </div>

                                <?php if ($_SESSION['permissao_selecionar_solicitante'] == 1) { ?>
                                    <div class="col-6">
                                        <label for="selectSolicitante" class="form-label">Solicitante</label>
                                        <select class="form-select" id="selectSolicitante" name="selectSolicitante">
                                            <option disabled selected value="">Selecione o solicitante</option>
                                            <?php
                                            // Verifique se $pdo está inicializado corretamente
                                            if ($pdo) {
                                                $sql_solicitante = "SELECT
                                                                    u.id as 'idUsuario',
                                                                    p.nome as 'solicitante'
                                                                    FROM
                                                                    usuarios as u
                                                                    LEFT JOIN
                                                                    pessoas as p
                                                                    ON
                                                                    p.id = u.pessoa_id
                                                                    WHERE
                                                                    u.active = 1
                                                                    ORDER BY
                                                                    p.nome ASC";

                                                try {
                                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                    // Execute a consulta SQL e verifique se foi bem-sucedida
                                                    if ($stmt = $pdo->query($sql_solicitante)) {
                                                        $resultadoSolicitante = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($resultadoSolicitante as $rowSolicitante) {
                                                            $idUsuario = $rowSolicitante['idUsuario'];
                                                            $solicitante = $rowSolicitante['solicitante'];
                                                            echo "<option value='$idUsuario'>$solicitante</option>";
                                                        }
                                                    } else {
                                                        echo "Erro ao executar a consulta SQL.";
                                                    }
                                                } catch (PDOException $e) {
                                                    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
                                                }
                                            } else {
                                                echo "Erro ao conectar ao banco de dados.";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php } ?>

                                <?php if ($_SESSION['permissao_selecionar_atendente'] == 1) { ?>
                                    <div class="col-6">
                                        <label for="selectAtendente" class="form-label">Atendente</label>
                                        <select class="form-select" id="selectAtendente" name="selectAtendente">
                                            <option disabled selected value="">Selecione o atendente</option>
                                            <?php
                                            // Verifique se $pdo está inicializado corretamente
                                            if ($pdo) {
                                                $sql_atendentes = "SELECT
                                                                    u.id as 'idUsuario',
                                                                    p.nome as 'atendente'
                                                                    FROM
                                                                    usuarios as u
                                                                    LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                                                    LEFT JOIN empresas as e ON e.id = u.empresa_id
                                                                    WHERE
                                                                    u.active = 1
                                                                    and
                                                                    e.atributoEmpresaPropria = 1
                                                                    ORDER BY
                                                                    p.nome ASC";

                                                try {
                                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                    // Execute a consulta SQL e verifique se foi bem-sucedida
                                                    if ($stmt = $pdo->query($sql_atendentes)) {
                                                        $resultadoAtendente = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                        foreach ($resultadoAtendente as $rowAtendente) {
                                                            $idUsuario = $rowAtendente['idUsuario'];
                                                            $atendente = $rowAtendente['atendente'];

                                                            echo "<option value='$idUsuario'>$atendente</option>";
                                                        }
                                                    } else {
                                                        echo "Erro ao executar a consulta SQL.";
                                                    }
                                                } catch (PDOException $e) {
                                                    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
                                                }
                                            } else {
                                                echo "Erro ao conectar ao banco de dados.";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php } ?>

                                <div class="col-6" id="selectDataConclusao" style="display: none;">
                                    <label for="dataConclusao" class="form-label">Data de conclusão esperada</label>
                                    <?php
                                    $data_minima_formatada = date('Y-m-d\TH:i', strtotime($data_minima));
                                    ?>
                                    <input type="datetime-local" class="form-control" id="dataConclusao"
                                        name="dataConclusao" min="<?= $data_minima_formatada ?>">
                                </div>

                                <br><br><br>
                                <?php if ($_SESSION['permissao_selecionar_competencias'] == 1) { ?>
                                    <h5 class="card-title">Competências necessárias para atendimento do chamado</h5>
                                    <div class="row mb-4">
                                        <?php
                                        $competencias =
                                            "SELECT
                                                                c.id as idCompetencia,
                                                                c.competencia as competencia
                                                                FROM
                                                                competencias as c
                                                                WHERE
                                                                c.active = 1
                                                                ORDER BY 
                                                                c.competencia ASC";
                                        $r_competencias = mysqli_query($mysqli, $competencias);
                                        while ($c_competencias = mysqli_fetch_assoc($r_competencias)) {
                                            $idCompetencia = $c_competencias['idCompetencia'];
                                            $competencia = $c_competencias['competencia'];
                                            ?>
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input type="hidden" name="competencia_ids[]" value="<?= $idCompetencia ?>">

                                                    <input class="form-check-input" type="checkbox"
                                                        name="competencia<?= $idCompetencia ?>"
                                                        id="competencia<?= $idCompetencia ?>">
                                                    <label class="form-check-label" for="competencia<?= $idCompetencia ?>">
                                                        <?= $competencia ?>
                                                    </label>
                                                </div>
                                            </div>

                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <hr class="sidebar-divider">

                                <div class="col-6">
                                    <label for="assuntoChamado" class="form-label">Assunto*</label>
                                    <input type="text" class="form-control" id="assuntoChamado" name="assuntoChamado"
                                        required>
                                </div>

                                <div class="col-12">
                                    <label for="relatoChamado" class="form-label">Descreva a situação*</label>
                                    <textarea rows="8" id="relatoChamado" name="relatoChamado" class="form-control"
                                        maxlength="1000" required></textarea>

                                </div>

                                <hr class="sidebar-divider">

                                <div class="col-4"></div>

                                <div class="col-4" style="text-align: center;">

                                    <div id="loadingMessage" style="display: none;">
                                        <div class="spinner-border text-success" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>

                                    <button id="btnAbrirChamado" class="btn btn-sm btn-danger" type="submit">Abrir
                                        Chamado</button>

                                    <a href="/servicedesk/consultar_chamados/index.php"> <input id="btnVoltar" type="button"
                                            value="Voltar" class="btn btn-sm btn-secondary"></input></a>
                                </div>

                                <div class="col-4"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <?php
    require "abrir_chamado_admin.php";
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>