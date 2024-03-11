<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "50";
$uid = $_SESSION['id'];
$equipe_id = $_SESSION['equipe_id'];
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
    $permite_abrir_chamados_outras_empresas = $_SESSION['permite_abrir_chamados_outras_empresas'];

    if ($permite_abrir_chamados_outras_empresas == 1) {
        $sql_lista_empresas =
            "SELECT emp.id as id_empresa, emp.fantasia as fantasia_empresa
        FROM empresas as emp
        WHERE atributoCliente = '1'
        ORDER BY
        emp.fantasia ASC
        ";
    } else if ($permite_abrir_chamados_outras_empresas == 0) {
        $sql_lista_empresas =
            "SELECT emp.id as id_empresa, emp.fantasia as fantasia_empresa
        FROM empresas as emp
        WHERE emp.id = $s_empresaID
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
                            <div class="float-end">
                                <button title="Tipos de Chamados" data-bs-toggle="modal" data-bs-target="#modalDetalhesTC" type="button" style="margin-top: 5px;" class="btn btn-sm btn-warning rounded-pill">?</button>
                            </div>
                            <form id="formAbrirChamado" action="/servicedesk/novo_chamado/processa/add.php" method="POST" class="row g-3">

                                <span id="msg"></span>

                                <input hidden id="solicitante" name="solicitante" value="<?= $uid ?>"></input>

                                <div class="col-6">
                                    <label for="empresaChamado" class="form-label">Empresa*</label>
                                    <select class="form-select" id="empresaChamado" name="empresaChamado" required>
                                        <option disabled selected value="">Selecione a empresa</option>
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                        while ($tipos = mysqli_fetch_object($resultado)) :
                                            echo "<option value='$tipos->id_empresa'> $tipos->fantasia_empresa</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="tipoChamado" class="form-label">Tipo de chamado* </label>
                                    <select class="form-select" id="tipoChamado" name="tipoChamado" required>
                                        <option disabled selected value="">Selecione o tipo de chamado</option>
                                        <?php

                                        $lista_tipos_chamados =
                                            "SELECT tc.id as idTipo,  tc.tipo as tipoChamado, tc.permite_data_entrega as 'permite_data_entrega', tc.horas_prazo_entrega as 'horas_prazo_entrega' 
                                            FROM chamados_autorizados_abertura as caas
                                            LEFT JOIN tipos_chamados as  tc ON tc.id = caas.tipo_id
                                            WHERE tc.active = 1 and caas.equipe_id = $equipe_id
                                            ORDER BY tc.tipo ASC";


                                        $r_lista_tipos_chamados = mysqli_query($mysqli, $lista_tipos_chamados);

                                        while ($tipos_chamados = mysqli_fetch_object($r_lista_tipos_chamados)) {
                                            $permite_data_entrega = $tipos_chamados->permite_data_entrega;
                                            $data_permitida = $permite_data_entrega ? '1' : '0';
                                            $horas_prazo_entrega = $tipos_chamados->horas_prazo_entrega;

                                            echo "<option value='$tipos_chamados->idTipo' data-permite-data-entrega='$data_permitida' data-horas-prazo-entrega='$horas_prazo_entrega' data-nao-permite-atendente>$tipos_chamados->tipoChamado</option>";


                                            if ($tipos_chamados->permite_data_entrega == 1) {
                                                $data_minima = date('Y-m-d H:i', strtotime("+ $horas_prazo_entrega hours"));
                                            } else {
                                                $data_minima = "";
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

                                <?php if ($_SESSION['permite_selecionar_solicitantes_abertura_chamado'] == 1) { ?>
                                    <div class="col-6">
                                        <label for="selectSolicitante" class="form-label">Solicitante</label>
                                        <select class="form-select" id="selectSolicitante" name="selectSolicitante">
                                            <option disabled selected value="">Selecione a Empresa</option>
                                        </select>
                                    </div>
                                <?php } ?>

                                <?php if ($_SESSION['permite_selecionar_atendente_abertura_chamado'] == 1) { ?>
                                    <div class="col-6">
                                        <label for="selectAtendente" class="form-label">Atendente</label>
                                        <select class="form-select" id="selectAtendente" name="selectAtendente">
                                            <option disabled selected value="">Selecione o tipo de chamado</option>
                                        </select>
                                    </div>
                                <?php } ?>

                                <div class="col-6" id="selectDataConclusao" style="display: none;">
                                    <label for="dataConclusao" class="form-label">Data de conclusão esperada</label>
                                    <?php
                                    $data_minima_formatada = date('Y-m-d\TH:i', strtotime($data_minima));
                                    ?>
                                    <input type="datetime-local" class="form-control" id="dataConclusao" name="dataConclusao" min="<?= $data_minima_formatada ?>">
                                </div>

                                <br><br><br>
                                <?php if ($_SESSION['permite_selecionar_competencias_abertura_chamado'] == 1) { ?>
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

                                                    <input class="form-check-input" type="checkbox" name="competencia<?= $idCompetencia ?>" id="competencia<?= $idCompetencia ?>">
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
                                    <input type="text" class="form-control" id="assuntoChamado" name="assuntoChamado" required>
                                </div>

                                <div class="col-12">
                                    <label for="relatoChamado" class="form-label">Descreva a situação*</label>
                                    <!--<textarea rows="8" id="relatoChamado" name="relatoChamado" class="form-control" maxlength="1000" required></textarea>-->
                                    <textarea rows="8" id="relatoChamado" name="relatoChamado" class="form-control" maxlength="1000" required disabled>Selecione primeiro o tipo de chamado</textarea>


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

                                    <a href="/servicedesk/consultar_chamados/index.php"> <input id="btnVoltar" type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
                                </div>

                                <div class="col-4"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <div class="modal fade" id="modalDetalhesTC" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tipos de Chamados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $descricao_tipos_chamados = "SELECT tc.descricao as descricao, tc.tipo as tipo
                                FROM chamados_autorizados_abertura as caas
                                LEFT JOIN tipos_chamados as  tc ON tc.id = caas.tipo_id
                                WHERE tc.active = 1 and caas.equipe_id = :equipe_id
                                ORDER BY tc.tipo ASC";

                    $stmt = $pdo->prepare($descricao_tipos_chamados);
                    $stmt->bindParam(':equipe_id', $equipe_id, PDO::PARAM_INT);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<p><b>" . $row["tipo"] . "</b><br>";
                            echo !empty($row["descricao"]) ? $row["descricao"] : "Sem descrição";
                            echo "</p>";
                        }
                    } else {
                        echo "<p>Nenhum chamado liberado.</p>";
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

<?php
    require "abrir_chamado_admin.php";
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>