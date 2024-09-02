<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "73";
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
?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>METABASE</h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10"></div>
                        <div class="col-lg-2">
                            <button style="margin-top: 15px;" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal_novo_dashboard">Criar Novo</button>
                        </div>
                    </div>
                    <br>
                    <table class="table table-striped ">
                        <thead>
                            <tr style="text-align: center;">
                                <th scope="col">Dashboard</th>
                                <th scope="col">URL</th>
                                <th scope="col">Visualizar</th>
                                <th scope="col">Abrir Link</th>
                                <th scope="col">Editar</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT id, dashboard, url, token FROM metabase WHERE active = 1 ORDER BY dashboard ASC";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr style='vertical-align: middle; text-align: center;'>
                                    <td><?= htmlspecialchars($row['dashboard']) ?></td>
                                    <td><?= htmlspecialchars($row['url']) ?></td>
                                    <td>
                                        <a href="dashboard.php?id=<?= htmlspecialchars($row['token']) ?>" title="Ver Dashboard">
                                            <i class="bi bi-columns-gap" style="margin-left: -5px;"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= $row['url'] ?>" target="_blank">
                                            <i class="bi bi-link" style="margin-left: -5px;"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="editar.php?id=<?= htmlspecialchars($row['id']) ?>" title="Editar">
                                            <i class="bi bi-tools" style="margin-left: -5px;"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>


                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="modal_novo_dashboard" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Dashboard</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="processa/novo_dashboard.php">
                        <div class="col-8">
                            <label class="form-label" for="dashboard">Dashboard</label>
                            <input required class="form-control" id="dashboard" name="dashboard">
                        </div>
                        <br>
                        <div class="col-10">
                            <label class="form-label" for="url">URL</label>
                            <input required class="form-control" id="url" name="url">
                        </div>
                        <br><br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-danger">Criar Nova</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>