<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "40";
$uid = $_SESSION['id'];

$permissions_submenu =
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

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

    if (isset($_GET['tab']) && $_GET['tab'] === 'email') {
        $nav_email = "active";
        $tab_email = "show active";
        $nav_wr = "";
        $tab_wr = "";
    } else if (isset($_GET['tab']) && $_GET['tab'] === 'wr') {
        $nav_email = "";
        $tab_email = "";
        $nav_wr = "active";
        $tab_wr = "show active";
    } else {
        $nav_email = "active";
        $tab_email = "show active";
        $nav_wr = "";
        $tab_wr = "";
    }

?>
<style>
    #tabelaLista:hover {
        cursor: pointer;
        background-color: #E0FFFF;
    }
</style>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Templates Comunicação</h1>
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
                                                <button class="nav-link <?= $nav_email ?>" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab" aria-controls="email" aria-selected="true">E-mail</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link <?= $nav_wr ?>" id="wr-tab" data-bs-toggle="tab" data-bs-target="#wr" type="button" role="tab" aria-controls="wr" aria-selected="false">WR Gateway</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content pt-2" id="myTabContent">
                                            <div class="tab-pane fade <?= $tab_email ?>" id="email" role="tabpanel" aria-labelledby="email-tab">
                                                <?php
                                                require "tab/email.php";
                                                ?>
                                            </div>
                                            <div class="tab-pane fade <?= $tab_wr ?>" id="wr" role="tabpanel" aria-labelledby="wr-tab">
                                                <?php
                                                require "tab/wr.php";
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
require "../../includes/securityfooter.php";
?>