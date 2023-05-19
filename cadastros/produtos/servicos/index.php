<?php
require "../../../includes/menu.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Serviços</h1>
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
                                            <button class="nav-link active" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab" aria-controls="service" aria-selected="true">Serviços</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="itens-tab" data-bs-toggle="tab" data-bs-target="#itens" type="button" role="tab" aria-controls="itens" aria-selected="false">Itens de Serviço</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="service" role="tabpanel" aria-labelledby="service-tab">
                                            <?php
                                            require "tab/service.php";
                                            ?>
                                        </div>
                                        <div class="tab-pane fade" id="itens" role="tabpanel" aria-labelledby="itens-tab">
                                            <?php
                                            require "tab/itens.php";
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
require "js.php";
require "../../../includes/footer.php";
?>