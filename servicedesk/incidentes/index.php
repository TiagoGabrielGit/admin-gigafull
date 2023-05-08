<?php
require "../../includes/menu.php";

$usuarioID = $_SESSION['id'];
$sql_parceiro =
    "SELECT
parceiroRN_id as parceiro
FROM
usuarios as u
WHERE
u.id = $usuarioID
";

$r_sql_parceiro = mysqli_query($mysqli, $sql_parceiro);
$campo_parceiro = $r_sql_parceiro->fetch_array();
$parceiroID = $campo_parceiro['parceiro'];

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
                        <h5 class="card-title">INCIDENTES</h5>


                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_abertos ?>" id="abertos-tab" data-bs-toggle="tab" data-bs-target="#abertos" type="button" role="tab" aria-controls="abertos" aria-selected="true">Abertos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_prevExcedido ?>" id="prevExcedido-tab" data-bs-toggle="tab" data-bs-target="#prevExcedido" type="button" role="tab" aria-controls="prevExcedido" aria-selected="true">Previsão Excedida</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_fechados ?>" id="fechados-tab" data-bs-toggle="tab" data-bs-target="#fechados" type="button" role="tab" aria-controls="fechados" aria-selected="false">Normalizados</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade <?= $tab_abertos ?>" id="abertos" role="tabpanel" aria-labelledby="abertos-tab">
                                <?php
                                require "tabs/abertos.php";
                                ?>
                            </div>

                            <div class="tab-pane fade <?= $tab_prevExcedido ?>" id="prevExcedido" role="tabpanel" aria-labelledby="prevExcedido-tab">
                                <?php
                                require "tabs/prevExcedida.php";
                                ?>
                            </div>

                            <div class="tab-pane fade <?= $tab_fechados ?>" id="fechados" role="tabpanel" aria-labelledby="fechados-tab">
                                <?php
                                require "tabs/fechados.php";
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