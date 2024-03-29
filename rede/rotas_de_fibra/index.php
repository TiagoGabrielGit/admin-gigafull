<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];
$page_type = "submenu";
$menu_submenu_id = "30";


if ($page_type == "submenu") {
    $permissions =
        "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $menu_submenu_id";
} else if ($page_type == "menu") {
    $permissions =
        "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_menu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $menu_submenu_id";
}
$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET['rotasDeFibra']) && $_GET['rotasDeFibra'] === 'rotas') {
            $nav_rotas = "active";
            $tab_rotas = "show active";
            $nav_interessados = "";
            $tab_interessados = "";
        } else if (isset($_GET['rotasDeFibra']) && $_GET['rotasDeFibra'] === 'interessados') {
            $nav_rotas = "";
            $tab_rotas = "";
            $nav_interessados = "active";
            $tab_interessados = "show active";
        } else {
            $nav_rotas = "active";
            $tab_rotas = "show active";
            $nav_interessados = "";
            $tab_interessados = "";
        }
    }
?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Rotas de Fibra</h1>
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
                                                <button class="nav-link <?= $nav_rotas ?>" id="rotas-tab" data-bs-toggle="tab" data-bs-target="#rotas" type="button" role="tab" aria-controls="rotas" aria-selected="true">Rotas</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link <?= $nav_interessados ?>" id="interessados-tab" data-bs-toggle="tab" data-bs-target="#interessados" type="button" role="tab" aria-controls="interessados" aria-selected="false">Interessados</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content pt-2" id="myTabContent">
                                            <div class="tab-pane fade <?= $tab_rotas ?>" id="rotas" role="tabpanel" aria-labelledby="rotas-tab">
                                                <?php
                                                require "tab/rotas.php";
                                                ?>
                                            </div>
                                            <div class="tab-pane fade <?= $tab_interessados ?>" id="interessados" role="tabpanel" aria-labelledby="interessados-tab">
                                                <?php
                                                require "tab/interessados.php";
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
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php"; ?>