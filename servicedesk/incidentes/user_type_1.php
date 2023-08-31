<?php

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['tabAbertos'])) {
        $tab_abertos = "show active";
        $nav_abertos = "active";
        $tab_fechados = "";
        $nav_fechados = "";
        $tab_prevExcedido = "";
        $nav_prevExcedido = "";
    } else if (isset($_POST['tabFechados'])) {
        $tab_abertos = "";
        $nav_abertos = "";
        $tab_fechados = "show active";
        $nav_fechados = "active";
        $tab_prevExcedido = "";
        $nav_prevExcedido = "";
    } else if (isset($_POST['tabPrevExcedido'])) {
        $tab_abertos = "";
        $nav_abertos = "";
        $tab_fechados = "";
        $nav_fechados = "";
        $tab_prevExcedido = "show active";
        $nav_prevExcedido = "active";
    }
} else {
    $tab_abertos = "show active";
    $nav_abertos = "active";
    $tab_fechados = "";
    $nav_fechados = "";
    $tab_prevExcedido = "";
    $nav_prevExcedido = "";
}

$sql_lista_classificacoes =
    "SELECT
ic.id as idClassificacao,
ic.classificacao as classificacao
FROM
incidentes_classificacao as ic
WHERE
ic.active = 1
ORDER BY
ic.classificacao ASC";

if (empty($_POST['pesquisaIncidenteAberto'])) {
    $_POST['pesquisaIncidenteAberto'] = "%";
}

if (empty($_POST['pesquisaIncidenteAbertoClassificacao'])) {
    $_POST['pesquisaIncidenteAbertoClassificacao'] = "%";
}

$pesquisaIncidenteAberto = $_POST['pesquisaIncidenteAberto'];
$pesquisaIncidenteAbertoClassificacao = $_POST['pesquisaIncidenteAbertoClassificacao'];

?>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <h5 class="card-title">INCIDENTES</h5>
                            </div>
                            <div class="col-lg-2">
                                <!-- Basic Modal -->
                                <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoIncidente">
                                    Novo Incidente
                                </button>
                            </div>
                        </div>
                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_abertos ?>" id="abertos-tab" data-bs-toggle="tab" data-bs-target="#abertos" type="button" role="tab" aria-controls="abertos" aria-selected="true">Abertos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_fechados ?>" id="fechados-tab" data-bs-toggle="tab" data-bs-target="#fechados" type="button" role="tab" aria-controls="fechados" aria-selected="false">Normalizados</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade <?= $tab_abertos ?>" id="abertos" role="tabpanel" aria-labelledby="abertos-tab">
                                <?php
                                require "tabs/user_type_1/abertos.php";
                                ?>
                            </div>

                            <div class="tab-pane fade <?= $tab_fechados ?>" id="fechados" role="tabpanel" aria-labelledby="fechados-tab">
                                <?php
                                require "tabs/user_type_1/fechados.php";
                                ?>
                            </div>
                        </div><!-- End Default Tabs -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<div class="modal fade" id="modalNovoIncidente" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Incidente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <!-- Vertical Form -->
                    <form method="POST" id="cadastraIncidente" class="row g-3">
                        <span id="msgCadastrarIncidente1"></span>

                        <input id="autor" name="autor" type="text" class="form-control" value="<?= $usuarioID ?>" required readonly hidden>
                        <div class="col-lg-6">

                            <div class="col-12">
                                <label for="incidente" class="form-label">Incidente*</label>
                                <input name="incidente" type="text" class="form-control" id="incidente" required>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="previsao" class="form-label">Previsão de Conclusão</label>
                                    <input name="previsao" type="datetime-local" class="form-control" id="previsao">
                                </div>
                                <div class="col-6">
                                    <label for="classificacao" class="form-label">Classificação*</label>
                                    <select id="classificacao" name="classificacao" class="form-select" required>
                                        <option disabled selected value="">Selecione</option>

                                        <?php
                                        $sql_classificacao =
                                            "SELECT
                                            ic.id as idClassificacao,
                                            ic.classificacao as classificacao
                                        FROM
                                            incidentes_classificacao as ic
                                        WHERE
                                            ic.active = 1
                                        ORDER BY
                                            ic.classificacao ASC";

                                        $r_classificacao = mysqli_query($mysqli, $sql_classificacao);
                                        while ($c_classificacao = mysqli_fetch_object($r_classificacao)) :
                                            echo "<option value='$c_classificacao->idClassificacao'> $c_classificacao->classificacao</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="col-12">
                                <label for="vinculado" class="form-label">Vinculado a Equipamento*</label>
                                <select id="vinculado" name="vinculado" class="form-select" onchange="showEquipamentos(this.value)" required>
                                    <option value="">Selecione</option>
                                    <option value="sim">Sim</option>
                                    <option value="nao">Não</option>
                                </select>
                            </div>

                            <div id="equipamentosContainer" style="display: none;">
                                <div class="col-12">
                                    <label for="equipamento" class="form-label">Equipamento*</label>
                                    <select id="equipamento" name="equipamento" class="form-select">
                                        <option disabled selected value="">Selecione</option>
                                        <?php
                                        $sql_equipamentos =
                                            "SELECT
                                            eqpop.id as id,
                                            eqpop.hostname as equipamento
                                            FROM
                                            equipamentospop as eqpop
                                            WHERE
                                            eqpop.deleted = 1
                                            ORDER BY
                                            eqpop.hostname ASC";

                                        $r_equipamentos = mysqli_query($mysqli, $sql_equipamentos);
                                        while ($c_equipamentos = mysqli_fetch_object($r_equipamentos)) :
                                            echo "<option value='$c_equipamentos->id'> $c_equipamentos->equipamento</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <hr class="sidebar-divider">

                        <div class="text-center">
                            <span id="msgCadastrarIncidente2"></span>
                            <input id="btnAbrirIncidente" name="btnAbrirIncidente" type="button" value="Abrir Incidente" class="btn btn-danger"></input>
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                        </div>
                    </form><!-- Vertical Form -->
                </div>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->


<?php
require "js.php";
require "../../includes/footer.php";
?>