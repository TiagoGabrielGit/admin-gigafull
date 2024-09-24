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
    $id = $_GET['id'];

    $sql =
        "SELECT
        api.api_name as api_name,
        api.id as api_id,
        api.api_route as api_route,
        CASE
        WHEN api.active = 1 THEN 'Ativo'
        WHEN api.active = 0 THEN 'Inativo'
        END active
    
        FROM api as api
        WHERE api.id = $id";

    $r_sql = mysqli_query($mysqli, $sql);
    $c_sql = $r_sql->fetch_array();

    $api_name = $c_sql['api_name'];

?>
    <main class="main" id="main">
        <div class="pagetitle">
            <h1>LOGs - <?= $api_name ?></h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <hr class="sidebar-divider">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;" scope="col">LOG</th>
                                <th style="text-align: center;" scope="col">IP Origem</th>
                                <th style="text-align: center;" scope="col">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $lista_apis = "SELECT * FROM logs_apis_externas WHERE api_id = $id ORDER BY data DESC";
                            $r_apis = mysqli_query($mysqli, $lista_apis);

                            while ($c_apis = $r_apis->fetch_array()) {
                                // Formata a data no formato desejado
                                $data_formatada = date("d/m/y H:i:s", strtotime($c_apis['data']));
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?= $c_apis['id']; ?></td>
                                    <td style="text-align: center;"><?= $c_apis['log']; ?></td>
                                    <td style="text-align: center;"><?= $c_apis['ip_origem']; ?></td>
                                    <td style="text-align: center;"><?= $data_formatada; ?></td>
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