<?php
require "../../includes/menu.php";
?>

<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_tipo_chamado =
    "SELECT
tc.id as id_tipo,
tc.tipo as nome_tipo,
tc.horas_prazo_entrega as tempo_entrega,
tc.permite_data_entrega as permite_data_entrega,
CASE
    WHEN tc.active = 1 THEN 'Ativado'
    WHEN tc.active = 0 THEN 'Inativado'
END as ativo_tipo,
tc.mobile,
tc.mascara,
tc.afericao
FROM
tipos_chamados as tc
WHERE
tc.id = '$id'
";

$r_tipo_chamado = mysqli_query($mysqli, $sql_tipo_chamado) or die("Erro ao retornar dados");
$c_tipo_chamado = $r_tipo_chamado->fetch_array();

if ($c_tipo_chamado['ativo_tipo'] == "Ativado") {
    $checkSituacao1 = "checked";
    $checkSituacao0 = "";
} else if ($c_tipo_chamado['ativo_tipo'] == "Inativado") {
    $checkSituacao0 = "checked";
    $checkSituacao1 = "";
}
?>

<main id="main" class="main">
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
                                            <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab" aria-controls="dados" aria-selected="true">Informações</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="competencia-tab" data-bs-toggle="tab" data-bs-target="#competencia" type="button" role="tab" aria-controls="competencia" aria-selected="true">Competência</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="mascara-tab" data-bs-toggle="tab" data-bs-target="#mascara" type="button" role="tab" aria-controls="mascara" aria-selected="true">Mascara</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                                            <?php require "tabs/information.php" ?>
                                        </div>

                                        <div class="tab-pane fade" id="competencia" role="tabpanel" aria-labelledby="competencia-tab">
                                            <?php require "tabs/competencias.php" ?>
                                        </div>


                                        <div class="tab-pane fade" id="mascara" role="tabpanel" aria-labelledby="mascara-tab">
                                            <?php require "tabs/mascara.php" ?>
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
</main><!-- End #main -->



<?php
require "js.php";
require "../../includes/footer.php";
?>