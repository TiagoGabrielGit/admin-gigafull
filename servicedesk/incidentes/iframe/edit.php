<?php


require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

$submenu_id = "41";
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

    $id = $_GET['id'];
    $sql =
        "SELECT ii.id as id, e.fantasia as fantasia, ii.titulo as titulo, ii.token as token,
    CASE
    WHEN ii.active = 1 THEN 'Ativo'
    WHEN ii.active = 0 THEN 'Inativo'
    END AS active,
CASE
WHEN ii.protocoloERP = 1 THEN 'Ativo'
    WHEN ii.protocoloERP = 0 THEN 'Inativo'
END AS protocoloERP

    FROM incidentes_iframe as ii
    LEFT JOIN empresas as e ON e.id = ii.empresa_id
    WHERE ii.id = $id";

    $r_sql = mysqli_query($mysqli, $sql);
    $c_sql = $r_sql->fetch_array();

    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $domain = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . $domain;

?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>IFRAME INCIDENTES</h1>
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
                                                <label for="empresa" class="form-label">Empresa</label>
                                                <input disabled readonly value="<?= $c_sql['fantasia'] ?>" class="form-control"></input>
                                            </div>

                                            <div class="col-3">
                                                <label for="status" class="form-label">Status</label>
                                                <input disabled readonly value="<?= $c_sql['active'] ?>" class="form-control"></input>
                                            </div>

                                            <div class="col-3">
                                                <label for="protocoloERP" class="form-label">Consulta Protocolo ERP</label>
                                                <input disabled readonly value="<?= $c_sql['protocoloERP'] ?>" class="form-control"></input>
                                            </div>

                                            <div class="col-2">
                                                <?php
                                                if ($c_sql['active'] == "Ativo") { ?>
                                                    <a href='processa/inativar_iframe.php?id=<?= $id ?>' class='btn btn-sm btn-danger'>Inativar Iframe </a>
                                                <?php } else {
                                                }
                                                ?>
                                                <br> <br>
                                                <?php
                                                if ($c_sql['protocoloERP'] == "Ativo") { ?>
                                                    <a href='processa/desabilitar_protocolo.php?id=<?= $id ?>' class='btn btn-sm btn-danger'>Desabilitar Protocolo </a>
                                                <?php } else if ($c_sql['protocoloERP'] == "Inativo") { ?>
                                                    <a href='processa/habilitar_protocolo.php?id=<?= $id ?>' class='btn btn-sm btn-danger'>Habilitar Protocolo </a>
                                                <?php }
                                                ?>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label" for="url">URL Iframe</label>
                                                <input disabled readonly value="<?= $baseUrl . "/servicedesk/incidentes/iframe/view.php?token=" . $c_sql['token'] ?>" class="form-control"></input>
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
                                                // ... Código de conexão ao banco de dados ...

                                                $query_ips = "SELECT * FROM incidentes_iframe_ip_address as iiip WHERE iiip.incidentes_iframe_id = $id";

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
                    <h5 class="modal-title">Novo Iframe</h5>
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
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>