<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$menu_id = "24";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id 
    WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {

?>
    <main class="main" id="main">
        <div class="pagetitle">
            <h1>Gerenciamento de API</h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <hr class="sidebar-divider">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;" scope="col">ID</th>
                                <th style="text-align: center;" scope="col">API</th>
                                <th style="text-align: center;" scope="col">Status</th>
                                <th style="text-align: center;" scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $lista_apis =
                                "SELECT api.id as id, api.api_name as api_name, 
                                CASE
                                WHEN api.active = 1 THEN 'Ativo'
                                WHEN api.active = 0 THEN 'Inativo'
                                END as status
                                FROM api as api
                                ORDER BY api_name ASC";

                            $r_apis = mysqli_query($mysqli, $lista_apis);
                            while ($c_apis = $r_apis->fetch_array()) {
                            ?>

                                <tr>

                                    <td style="text-align: center;"><?= $c_apis['id']; ?></td>
                                    <td style="text-align: center;"><?= $c_apis['api_name']; ?></td>
                                    <td style="text-align: center;"><?= $c_apis['status']; ?></td>

                                    <td style="text-align: center;">
                                        <button title="Visualizar API" type="button" class="btn btn-sm btn-info" onclick="window.location.href = 'view.php?id=<?= $c_apis['id'] ?>';">
                                            <i class="bi bi-arrow-right-square"></i>
                                        </button>


                                        <button title="Visualizar API" type="button" class="btn btn-sm btn-warning" onclick="window.location.href = 'logs.php?id=<?= $c_apis['id'] ?>';">
                                            <i class="bi bi-terminal"></i>
                                        </button>
                                    </td>


                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');

?>