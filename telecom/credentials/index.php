<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "equipamentos/sql.php";
require "portal/sql.php";
require "vm/sql.php";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['tabVM'])) {
        $tab_vm = "show active";
        $nav_vm = "active";
        $tab_vmCloud = "";
        $nav_vmCloud = "";
        $tab_equipamento = "";
        $nav_equipamento = "";
        $tab_portal = "";
        $nav_portal = "";
        $tab_email = "";
        $nav_email = "";
    } else if (isset($_POST['tabequipamento'])) {
        $tab_equipamento = "show active";
        $nav_equipamento = "active";
        $tab_vmCloud = "";
        $nav_vmCloud = "";
        $tab_vm = "";
        $nav_vm = "";
        $tab_portal = "";
        $nav_portal = "";
        $tab_email = "";
        $nav_email = "";
    } else if (isset($_POST['tabportal'])) {
        $tab_portal = "show active";
        $nav_portal = "active";
        $tab_vmCloud = "";
        $nav_vmCloud = "";
        $tab_vm = "";
        $nav_vm = "";
        $tab_equipamento = "";
        $nav_equipamento = "";
        $tab_email = "";
        $nav_email = "";
    } else if (isset($_POST['tabVMCloud'])) {
        $tab_portal = "";
        $nav_portal = "";
        $tab_vmCloud = "show active";
        $nav_vmCloud = "active";
        $tab_vm = "";
        $nav_vm = "";
        $tab_equipamento = "";
        $nav_equipamento = "";
        $tab_email = "";
        $nav_email = "";
    } else if (isset($_POST['tabemail'])) {
        $tab_email = "show active";
        $nav_email = "active";
        $tab_portal = "";
        $nav_portal = "";
        $tab_vmCloud = "";
        $nav_vmCloud = "";
        $tab_vm = "";
        $nav_vm = "";
        $tab_equipamento = "";
        $nav_equipamento = "";
    }
} else {
    $tab_equipamento = "show active";
    $nav_equipamento = "active";
    $tab_vmCloud = "";
    $nav_vmCloud = "";
    $tab_vm = "";
    $nav_vm = "";
    $tab_portal = "";
    $nav_portal = "";
    $tab_email = "";
    $nav_email = "";
}
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
                                <button class="nav-link <?= $nav_equipamento ?>" id="equipamento-tab" data-bs-toggle="tab" data-bs-target="#equipamento" type="button" role="tab" aria-controls="equipamento" aria-selected="true">Equipamento</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_email ?>" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab" aria-controls="email" aria-selected="true">E-mail</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_portal ?>" id="portal-tab" data-bs-toggle="tab" data-bs-target="#portal" type="button" role="tab" aria-controls="portal" aria-selected="false">Portal</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_vm ?>" id="vm-tab" data-bs-toggle="tab" data-bs-target="#vm" type="button" role="tab" aria-controls="vm" aria-selected="false">VM - Hospedagem Local</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_vmCloud ?>" id="vmCloud-tab" data-bs-toggle="tab" data-bs-target="#vmCloud" type="button" role="tab" aria-controls="vmCloud" aria-selected="false">VM - Cloud (Beta)</button>
                            </li>
                        </ul> 

                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade <?= $tab_equipamento ?>" id="equipamento" role="tabpanel" aria-labelledby="equipamento-tab">
                                <?php
                                require "tabs/equipamentos.php";
                                ?>
                            </div>
                            <div class="tab-pane fade <?= $tab_email ?>" id="email" role="tabpanel" aria-labelledby="email-tab">
                                <?php
                                require "tabs/email.php";
                                ?>
                            </div>
                            <div class="tab-pane fade <?= $tab_portal ?>" id="portal" role="tabpanel" aria-labelledby="portal-tab">
                                <?php
                                require "tabs/portal.php"; 
                                ?>
                            </div>
                            <div class="tab-pane fade <?= $tab_vm ?>" id="vm" role="tabpanel" aria-labelledby="vm-tab">
                                <?php
                                require "tabs/vm.php";
                                ?>
                            </div>
                            <div class="tab-pane fade <?= $tab_vmCloud ?>" id="vmCloud" role="tabpanel" aria-labelledby="vmCloud-tab">
                                <?php
                                require "tabs/vmCloud.php";
                                ?>
                            </div>
                        </div><!-- End Default Tabs -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<?php
require "includes/scripts_pesquisa_equipamento.php";
require "includes/scripts_pesquisa_VM.php";
require "includes/scripts_add_equipamento.php";
require "includes/scripts_add_VM.php";
require "includes/scripts_portal.php";
require "includes/scripts_email.php";
require "../../includes/footer.php";
?>