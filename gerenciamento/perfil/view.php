<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];
$page_type = "submenu";
$menu_submenu_id = "17";


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

    $idPerfil = $_GET['idPerfil'];

    $sql_perfil =
        "SELECT
p.id as idPerfil,
p.perfil as perfil
FROM
perfil as p
WHERE
p.id = $idPerfil
";

    $r_sql_perfil = mysqli_query($mysqli, $sql_perfil);
    $c_sql_perfil = mysqli_fetch_assoc($r_sql_perfil);
?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Perfil - <?= $c_sql_perfil['perfil'] ?></h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <hr class="sidebar-divider">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span>
                                                    <b>
                                                        <h3>Menus</h3>
                                                    </b>
                                                </span>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <?php
                                                $menus =
                                                    "SELECT
                                                um.id as idMenu,
                                                um.url as urlMenu,
                                                um.menu as menu
                                                FROM
                                                url_menu as um
                                                ORDER BY 
                                                um.menu ASC";
                                                $r_menus = mysqli_query($mysqli, $menus);
                                                while ($c_menus = mysqli_fetch_assoc($r_menus)) {
                                                    $idmenu = $c_menus['idMenu'];
                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppm.id as idPermissao
                                                FROM
                                                perfil_permissoes_menu as ppm
                                                WHERE
                                                ppm.url_menu = $idmenu
                                                and
                                                ppm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input onclick="despermitirMenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="menu<?= $idmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirMenu">
                                                                <label class="form-check-label" for="menu<?= $idmenu ?>"><?= $c_menus['menu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input onclick="permitirMenu(<?= $idmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="menu<?= $idmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirMenu">
                                                                <label class="form-check-label" for="menu<?= $idmenu ?>"><?= $c_menus['menu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>

                                        <hr class="sidebar-divider">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span>
                                                    <b>
                                                        <h3>SUBMENU</h3>
                                                    </b>
                                                </span>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Produtos e Serviços</b></span>
                                                </div>
                                                <?php
                                                $submenu_produtoServico =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                url_submenu as us
                                                WHERE
                                                us.menu_id = 12
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_produtoServico = mysqli_query($mysqli, $submenu_produtoServico);
                                                while ($c_submenu_produtoServico = mysqli_fetch_assoc($r_submenu_produtoServico)) {
                                                    $idSubmenu = $c_submenu_produtoServico['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_produtoServico['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_produtoServico['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Informativos</b></span>
                                                </div>
                                                <?php
                                                $submenu_servicedesk =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                url_submenu as us
                                                WHERE
                                                us.menu_id = 17
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_servicedesk = mysqli_query($mysqli, $submenu_servicedesk);
                                                while ($c_submenu_servicedesk = mysqli_fetch_assoc($r_submenu_servicedesk)) {
                                                    $idSubmenu = $c_submenu_servicedesk['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_servicedesk['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_servicedesk['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>E-commerce</b></span>
                                                </div>
                                                <?php
                                                $submenu_ecommerce =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                url_submenu as us
                                                WHERE
                                                us.menu_id = 25
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_ecommerce = mysqli_query($mysqli, $submenu_ecommerce);
                                                while ($c_submenu_ecommerce = mysqli_fetch_assoc($r_submenu_ecommerce)) {
                                                    $idSubmenu = $c_submenu_ecommerce['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_ecommerce['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_ecommerce['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Comunicação</b></span>
                                                </div>
                                                <?php
                                                $submenu_comunicacao =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                url_submenu as us
                                                WHERE
                                                us.menu_id = 22
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_comunicacao = mysqli_query($mysqli, $submenu_comunicacao);
                                                while ($c_submenu_comunicacao = mysqli_fetch_assoc($r_submenu_comunicacao)) {
                                                    $idSubmenu = $c_submenu_comunicacao['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_comunicacao['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_comunicacao['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Manutenção Programada</b></span>
                                                </div>
                                                <?php
                                                $submenu_servicedesk =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                url_submenu as us
                                                WHERE
                                                us.menu_id = 21
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_servicedesk = mysqli_query($mysqli, $submenu_servicedesk);
                                                while ($c_submenu_servicedesk = mysqli_fetch_assoc($r_submenu_servicedesk)) {
                                                    $idSubmenu = $c_submenu_servicedesk['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_servicedesk['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_servicedesk['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Rede Neutra</b></span>
                                                </div>
                                                <?php
                                                $submenu_redeNeutra =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                    url_submenu as us
                                                WHERE
                                                us.menu_id = 13
                                                ORDER BY
                                                    us.submenu ASC";
                                                $r_submenu_redeNeutra = mysqli_query($mysqli, $submenu_redeNeutra);
                                                while ($c_submenu_redeNeutra = mysqli_fetch_assoc($r_submenu_redeNeutra)) {
                                                    $idSubmenu = $c_submenu_redeNeutra['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_redeNeutra['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_redeNeutra['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Gerenciamento</b></span>
                                                </div>
                                                <?php
                                                $submenu_gerenciamento =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                    url_submenu as us
                                                WHERE
                                                    us.menu_id = 14
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_gerenciamento = mysqli_query($mysqli, $submenu_gerenciamento);
                                                while ($c_submenu_gerenciamento = mysqli_fetch_assoc($r_submenu_gerenciamento)) {
                                                    $idSubmenu = $c_submenu_gerenciamento['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_gerenciamento['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_gerenciamento['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Relatórios</b></span>
                                                </div>
                                                <?php
                                                $submenu_relatorio =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                    url_submenu as us
                                                WHERE
                                                    us.menu_id = 19
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_relatorio = mysqli_query($mysqli, $submenu_relatorio);
                                                while ($c_submenu_relatorio = mysqli_fetch_assoc($r_submenu_relatorio)) {
                                                    $idSubmenu = $c_submenu_relatorio['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_relatorio['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_relatorio['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Sistema</b></span>
                                                </div>
                                                <?php
                                                $submenu_sistema =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                url_submenu as us
                                                WHERE
                                                us.menu_id = 15
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_sistema = mysqli_query($mysqli, $submenu_sistema);
                                                while ($c_submenu_sistema = mysqli_fetch_assoc($r_submenu_sistema)) {
                                                    $idSubmenu = $c_submenu_sistema['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_sistema['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_sistema['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Integração</b></span>
                                                </div>
                                                <?php
                                                $submenu_sistema =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                url_submenu as us
                                                WHERE
                                                us.menu_id = 23
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_sistema = mysqli_query($mysqli, $submenu_sistema);
                                                while ($c_submenu_sistema = mysqli_fetch_assoc($r_submenu_sistema)) {
                                                    $idSubmenu = $c_submenu_sistema['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_sistema['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_sistema['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Rede</b></span>
                                                </div>
                                                <?php
                                                $submenu_rede =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                    url_submenu as us
                                                WHERE
                                                    us.menu_id = 20
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_rede = mysqli_query($mysqli, $submenu_rede);
                                                while ($c_submenu_rede = mysqli_fetch_assoc($r_submenu_rede)) {
                                                    $idSubmenu = $c_submenu_rede['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_rede['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_rede['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Chamados</b></span>
                                                </div>
                                                <?php
                                                $submenu_rede =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                    url_submenu as us
                                                WHERE
                                                    us.menu_id = 4
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_rede = mysqli_query($mysqli, $submenu_rede);
                                                while ($c_submenu_rede = mysqli_fetch_assoc($r_submenu_rede)) {
                                                    $idSubmenu = $c_submenu_rede['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_rede['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_rede['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="col-12">
                                                    <span><b>Tipos de Chamados</b></span>
                                                </div>
                                                <?php
                                                $submenu_sistema =
                                                    "SELECT
                                                us.id as idSubmenu,
                                                us.url as urlSubmenu,
                                                us.submenu as submenu
                                                FROM
                                                url_submenu as us
                                                WHERE
                                                us.menu_id = 26
                                                ORDER BY
                                                us.submenu ASC";
                                                $r_submenu_sistema = mysqli_query($mysqli, $submenu_sistema);
                                                while ($c_submenu_sistema = mysqli_fetch_assoc($r_submenu_sistema)) {
                                                    $idSubmenu = $c_submenu_sistema['idSubmenu'];

                                                    $valida_check =
                                                        "SELECT
                                                count(*) as validaCheck,
                                                ppsm.id as idPermissao
                                                FROM
                                                perfil_permissoes_submenu as ppsm
                                                WHERE
                                                ppsm.url_submenu = $idSubmenu
                                                and
                                                ppsm.perfil_id = $idPerfil
                                                ";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="despermitirSubmenu(<?= $c_valida_check['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_sistema['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input onclick="permitirSubmenu(<?= $idSubmenu ?>, '<?= $idPerfil ?>')" class="form-check-input" type="checkbox" id="submenu<?= $idSubmenu ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirSubmenu">
                                                                <label class="form-check-label" for="submenu<?= $idSubmenu ?>"><?= $c_submenu_sistema['submenu'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
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
    require "modalDespermitirMenu.php";
    require "modalPermitirMenu.php";
    require "modalDespermitirSubmenu.php";
    require "modalPermitirSubmenu.php";
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";

?>