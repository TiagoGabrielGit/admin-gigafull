<?php
require "../includes/menu.php";
require "../conexoes/conexao_pdo.php";

$submenu_id = "24";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

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

    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $domain = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . $domain;

?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>GERENCIAMENTO DE API</h1>
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
                                            <div class="col-4">
                                                <label for="api_name" class="form-label">API Name</label>
                                                <input disabled readonly value="<?= $c_sql['api_name'] ?>" class="form-control"></input>
                                            </div>

                                            <div class="col-3">
                                                <label for="status" class="form-label">Status</label>
                                                <input disabled readonly value="<?= $c_sql['active'] ?>" class="form-control"></input>
                                            </div>
                                            <div class="col-3">
                                            </div>
                                            <div class="col-2">
                                                <?php
                                                if ($c_sql['active'] == "Ativo") { ?>
                                                    <a href='processa/inativar_api.php?id=<?= $id ?>' class='btn btn-sm btn-danger'>Inativar API </a>
                                                <?php } else { ?>
                                                    <a href='processa/ativar_api.php?id=<?= $id ?>' class='btn btn-sm btn-danger'>Ativar API </a>
                                                <?php }
                                                ?>
                                                <br> <br>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="form-label" for="api_route">API Route</label>
                                                <input disabled readonly value="<?= $baseUrl . $c_sql['api_route'] ?>" class="form-control"></input>
                                            </div>
                                        </div>

                                        <hr class="sidebar-divider">
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <h5 class="card-title">IPs Liberados</h5>
                                            </div>
                                            <div class="col-lg-2" style="margin-top: 10px;">
                                                <button style="margin-top: 15px" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                    Liberar IP
                                                </button>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Descrição</th>
                                                    <th scope="col">Endereço IP</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $query_ips = "SELECT * FROM api_externa_ip WHERE api_id = $id";

                                                try {
                                                    $stmt = $conn->query($query_ips);

                                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        $ip_id = $row['id'];
                                                        $endereco_ip = $row['ip'];
                                                        $descricao = $row['descricao'];

                                                        echo "<tr>";
                                                        echo "<td>$ip_id</td>";
                                                        echo "<td>$descricao</td>";
                                                        echo "<td>$endereco_ip</td>";
                                                        echo "<td><a href='processa/excluir_ip.php?id=$ip_id' class='btn btn-sm btn-danger'>Excluir </a></td>";

                                                        echo "</tr>";
                                                    }
                                                } catch (PDOException $e) {
                                                    echo "Erro na consulta: " . $e->getMessage();
                                                }

                                                // Feche a conexão com o banco de dados
                                                $conn = null;
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- End Default Table Example -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Liberação de IP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" action="processa/liberar_ip.php">
                            <input value="<?= $id ?>" readonly hidden name="id" id="id">
                            <div class="row">
                                <div class="col-6">
                                    <label for="ip" class="form-label">Endereço IP</label>
                                    <input id="ip" name="ip" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <input id="descricao" name="descricao" class="form-control" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Basic Modal-->
<?php
} else {
    require "../acesso_negado.php";
}
require "../includes/securityfooter.php";
?>