<?php
require "../includes/menu.php";

require "../conexoes/conexao_pdo.php";

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
    <style>
        #tabelaLista:hover {
            cursor: pointer;
            background-color: #E0FFFF;
        }
    </style>
    <main class="main" id="main">
        <div class="pagetitle">
            <h1>Gerenciamento de API</h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <hr class="sidebar-divider">
                    <table class="table datatable" id="styleTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">API</th>
                                <th scope="col">Status</th>
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

                                <tr id="tabelaLista" onclick="location.href='view.php?id=<?= $c_apis['id'] ?>'">

                                    <td><?= $c_apis['id']; ?></td>
                                    <td><?= $c_apis['api_name']; ?></td>
                                    <td><?= $c_apis['status']; ?></td>
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
    require "../acesso_negado.php";
}
require "../includes/securityfooter.php";
?>