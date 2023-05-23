<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
require "../../conexoes/conexao.php";

$idCompetencia = $_GET['id'];

$sql = "SELECT
            c.id AS idCompetencia,
            c.competencia AS competencia,
            c.active AS activeID,
            CASE
                WHEN c.active = '1' THEN 'Ativado'
                WHEN c.active = '0' THEN 'Inativado'
            END AS active
        FROM
            competencias AS c
        WHERE
            c.id = " . mysqli_real_escape_string($mysqli, $idCompetencia) . "
        ORDER BY
            c.competencia ASC";

$resultado = mysqli_query($mysqli, $sql);
$campos = $resultado->fetch_array();


if ($campos['active'] == "Ativado") {
    $checkSituacao1 = "checked";
    $checkSituacao0 = "";
} else if ($campos['active'] == "Inativado") {
    $checkSituacao0 = "checked";
    $checkSituacao1 = "";
}

?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $campos['competencia']; ?></h5>

                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="competencia-tab" data-bs-toggle="tab" data-bs-target="#competencia" type="button" role="tab" aria-controls="competencia" aria-selected="true">Competência</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="competencia" role="tabpanel" aria-labelledby="competencia-tab">
                                <?php require "tabs/competencia.php" ?>
                            </div>
                        </div><!-- End Default Tabs -->

                    </div>
                </div>

            </div>

        </div>
    </section>

</main>

<?php
require "js.php";
require "../../includes/footer.php";
?>