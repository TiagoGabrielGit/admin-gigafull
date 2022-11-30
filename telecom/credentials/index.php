<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "equipamentos/sql.php";
require "portal/sql.php";
require "vm/sql.php";
?>



<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Credenciais</h5>

                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="equipamento-tab" data-bs-toggle="tab" data-bs-target="#equipamento" type="button" role="tab" aria-controls="equipamento" aria-selected="true">Equipamento</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="portal-tab" data-bs-toggle="tab" data-bs-target="#portal" type="button" role="tab" aria-controls="portal" aria-selected="false">Portal</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="vm-tab" data-bs-toggle="tab" data-bs-target="#vm" type="button" role="tab" aria-controls="vm" aria-selected="false">Maquina Virtual</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="equipamento" role="tabpanel" aria-labelledby="equipamento-tab">
                                <?php
                                require "tabs/equipamentos.php";
                                ?>
                            </div>
                            <div class="tab-pane fade" id="portal" role="tabpanel" aria-labelledby="portal-tab">
                                <?php
                                require "tabs/portal.php";
                                ?>
                            </div>
                            <div class="tab-pane fade" id="vm" role="tabpanel" aria-labelledby="vm-tab">
                                <?php
                                require "tabs/vm.php";
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