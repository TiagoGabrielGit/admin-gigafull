<?php
require "../../../includes/menu.php";

$usuarioID = $_SESSION['id'];

#$r_provisionamento = mysqli_query($mysqli, $sql_provisionamento);
#$campos = $r_provisionamento->fetch_array();

?>


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
                                            <button class="nav-link active" id="classificacao-tab" data-bs-toggle="tab" data-bs-target="#classificacao" type="button" role="tab" aria-controls="classificacao" aria-selected="true">Classificação</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="template-tab" data-bs-toggle="tab" data-bs-target="#template" type="button" role="tab" aria-controls="template" aria-selected="false">Template Integração</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="classificacao" role="tabpanel" aria-labelledby="classificacao-tab">
                                            <?php
                                            require "tab/classificacao.php";
                                            ?>
                                        </div>
                                        <div class="tab-pane fade" id="template" role="tabpanel" aria-labelledby="template-tab">
                                            <?php
                                            require "tab/template.php";
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