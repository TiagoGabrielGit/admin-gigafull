<?php

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['tabAbertos'])) {
        $tab_abertos = "show active";
        $nav_abertos = "active";
        $tab_fechados = "";
        $nav_fechados = "";
    } else if (isset($_POST['tabFechados'])) {
        $tab_abertos = "";
        $nav_abertos = "";
        $tab_fechados = "show active";
        $nav_fechados = "active";
    }
} else {
    $tab_abertos = "show active";
    $nav_abertos = "active";
    $tab_fechados = "";
    $nav_fechados = "";
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
                                require "tabs/user_type_3/abertos.php";
                                ?>
                            </div>


                            <div class="tab-pane fade <?= $tab_fechados ?>" id="fechados" role="tabpanel" aria-labelledby="fechados-tab">
                                <?php
                                require "tabs/user_type_3/fechados.php";
                                ?>
                            </div>
                        </div><!-- End Default Tabs -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require "../../includes/footer.php";
?>