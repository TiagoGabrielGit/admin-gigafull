<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "73";
$uid = $_SESSION['id'];

$permissions_submenu = "
    SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = :uid AND pp.url_submenu = :submenu_id";
$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->bindParam(':uid', $uid);
$exec_permissions_submenu->bindParam(':submenu_id', $submenu_id);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

    $id = $_GET['id'];

    // Consulta para carregar os dados existentes do dashboard
    $query = "SELECT dashboard, url, active FROM metabase WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $dashboard = $result['dashboard'];
        $url = $result['url'];
        $active = $result['active'];
    } else {
        // Redireciona se o dashboard não for encontrado
        header("Location: /relatorios/metabase/index.php");
        exit();
    }
?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>EDITAR CONFIGURAÇÕES</h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10"></div>
                        <div class="col-lg-2">
                            <a href="/relatorios/metabase/index.php">
                                <button style="margin-top: 15px;" type="button" class="btn btn-sm btn-danger">Voltar Listagem</button>
                            </a>
                        </div>
                    </div>
                    <br>

                    <form method="POST" action="processa/editar_dashboard.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                        <div class="row">
                            <div class="col-7">
                                <label class="form-label" for="dashboard">Dashboard</label>
                                <input required class="form-control" id="dashboard" name="dashboard" value="<?= htmlspecialchars($dashboard) ?>">
                            </div>

                            <div class="col-4">
                                <label class="form-label" for="active">Status</label>
                                <select id="active" name="active" class="form-select">
                                    <option value="1" <?= $active ? 'selected' : '' ?>>Ativo</option>
                                    <option value="0" <?= !$active ? 'selected' : '' ?>>Inativo</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="col-10">
                            <label class="form-label" for="url">URL</label>
                            <input required class="form-control" id="url" name="url" value="<?= htmlspecialchars($url) ?>">
                        </div>
                        <br>

                        <br><br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-danger">Salvar Alterações</button>
                        </div>
                    </form>
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
