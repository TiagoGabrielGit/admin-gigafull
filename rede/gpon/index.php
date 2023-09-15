<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "32";

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
	pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET['gpon']) && $_GET['gpon'] === 'olt') {
            $nav_gpon = "active";
            $tab_gpon = "show active";
            $nav_interessados = "";
            $tab_interessados = "";
            $nav_pon = "";
            $tab_pon = "";  
        } else if (isset($_GET['gpon']) && $_GET['gpon'] === 'interessados') {
            $nav_gpon = "";
            $tab_gpon = "";
            $nav_interessados = "active";
            $tab_interessados = "show active";
            $nav_pon = "";
            $tab_pon = "";  
        } else if (isset($_GET['gpon']) && $_GET['gpon'] === 'pon') {
            $nav_gpon = "";
            $tab_gpon = "";
            $nav_interessados = "";
            $tab_interessados = "";
            $nav_pon = "active";
            $tab_pon = "show active";   
        } else {
            $nav_gpon = "active";
            $tab_gpon = "show active";
            $nav_interessados = "";
            $tab_interessados = "";
            $nav_pon = "";
            $tab_pon = "";   
        }
    }
?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>GPON</h1>
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
                                                <button class="nav-link <?= $nav_gpon ?>" id="olt-tab" data-bs-toggle="tab" data-bs-target="#olt" type="button" role="tab" aria-controls="olt" aria-selected="true">OLTs</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link <?= $nav_interessados ?>" id="interessados-tab" data-bs-toggle="tab" data-bs-target="#interessados" type="button" role="tab" aria-controls="interessados" aria-selected="false">Interessados na OLT</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link <?= $nav_pon ?>" id="pon-tab" data-bs-toggle="tab" data-bs-target="#pon" type="button" role="tab" aria-controls="pon" aria-selected="false">PON</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content pt-2" id="myTabContent">
                                            <div class="tab-pane fade <?= $tab_gpon ?>" id="olt" role="tabpanel" aria-labelledby="olt-tab">
                                                <?php
                                                require "tab/olt.php";
                                                ?>
                                            </div>
                                            <div class="tab-pane fade <?= $tab_interessados ?>" id="interessados" role="tabpanel" aria-labelledby="interessados-tab">
                                                <?php
                                                require "tab/interessados.php";
                                                ?>
                                            </div>
                                            <div class="tab-pane fade <?= $tab_pon ?>" id="pon" role="tabpanel" aria-labelledby="pon-tab">
                                                <?php
                                                require "tab/pon.php";
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