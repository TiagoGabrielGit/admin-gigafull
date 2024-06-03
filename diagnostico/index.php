<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$menu_id = "28";
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

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Diagnóstico</h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <br>
                            <form method="POST" action="process_form.php">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label" for="codigo">Código do Cliente</label>
                                        <input placeholder="Digite o código do cliente" required class="form-control" id="codigo" name="codigo" type="text">
                                    </div>
                                    <div class="col-2">
                                        <button style="margin-top: 30px;" type="submit" class="btn btn-sm btn-danger">Pesquisar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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