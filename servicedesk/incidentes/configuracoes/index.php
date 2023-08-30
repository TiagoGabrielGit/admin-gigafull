<?php
require "../../../includes/menu.php";
$usuarioID = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['incidentesConfiguracao']) && $_GET['incidentesConfiguracao'] === 'classificacao') {
        $nav_classificacao = "active";
        $tab_classificacao = "show active";
        $nav_template = "";
        $tab_template = "";
        $nav_tipo = "";
        $tab_tipo = "";
    } else if (isset($_GET['incidentesConfiguracao']) && $_GET['incidentesConfiguracao'] === 'template') {
        $nav_classificacao = "";
        $tab_classificacao = "";
        $nav_template = "active";
        $tab_template = "show active";
        $nav_tipo = "";
        $tab_tipo = "";
    } else if (isset($_GET['incidentesConfiguracao']) && $_GET['incidentesConfiguracao'] === 'tipo') {
        $nav_classificacao = "";
        $tab_classificacao = "";
        $nav_template = "";
        $tab_template = "";
        $nav_tipo = "active";
        $tab_tipo = "show active";
    } else {
        $nav_classificacao = "active";
        $tab_classificacao = "show active";
        $nav_template = "";
        $tab_template = "";
        $nav_tipo = "";
        $tab_tipo = "";
    }
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Configurações</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link <?= $nav_classificacao ?>" id="classificacao-tab" data-bs-toggle="tab" data-bs-target="#classificacao" type="button" role="tab" aria-controls="classificacao" aria-selected="true">Classificação</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link <?= $nav_template ?>" id="template-tab" data-bs-toggle="tab" data-bs-target="#template" type="button" role="tab" aria-controls="template" aria-selected="false">Template Integração</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link <?= $nav_tipo ?>" id="tipos-tab" data-bs-toggle="tab" data-bs-target="#tipos" type="button" role="tab" aria-controls="tipos" aria-selected="false">Tipos Incidentes</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade <?= $tab_classificacao ?>" id="classificacao" role="tabpanel" aria-labelledby="classificacao-tab">
                                            <?php
                                            require "tab/classificacao.php";
                                            ?>
                                        </div>
                                        <div class="tab-pane fade <?= $tab_template ?>" id="template" role="tabpanel" aria-labelledby="template-tab">
                                            <?php
                                            require "tab/template.php";
                                            ?>
                                        </div>
                                        <div class="tab-pane fade <?= $tab_tipo ?>" id="tipos" role="tabpanel" aria-labelledby="tipos-tab">
                                            <?php
                                            require "tab/tipos.php";
                                            ?>
                                        </div>
                                    </div><!-- End Default Tabs -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "../../../includes/footer.php";
?>