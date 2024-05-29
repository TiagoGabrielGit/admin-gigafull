<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "58";
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
    $consulta_dados = "SELECT * FROM integracao_ozmap WHERE id = 1";
    $stmt = $pdo->prepare($consulta_dados);
    $stmt->execute();
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);


?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="text-left">
                                    <h5 class="card-title">Parametrizações API</h5>
                                </div>
                            </div>
                            <div class="row">
                                <hr class="sidebar-divider">

                                <form action="processa/update.php" method="POST">
                                    <div class="row">
                                        <div class="col-8">
                                            <label for="urlAPI" class="form-label">URL API</label>
                                            <input value="<?= $dados['urlAPI'] ?>" placeholder="https://sandbox.ozmap.com.br:9994/api/v2" class="form-control" id="urlAPI" name="urlAPI"></input>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <label for="chaveAutenticacao" class="form-label">Chave Autorização</label>
                                            <input value="<?= $dados['chaveAutenticacao'] ?>" class="form-control" id="chaveAutenticacao" name="chaveAutenticacao"></input>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <button class="btn btn-sm btn-danger" type="submit">Salvar Parametrização</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="text-left">
                                    <h5 class="card-title">Cadastro de API</h5>
                                </div>
                            </div>
                            <div class="row">
                                <hr class="sidebar-divider">

                                <form action="processa/cadastro_api.php" method="POST">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="descricaoAPI" class="form-label">Descrição API</label>
                                            <input class="form-control" id="descricaoAPI" name="descricaoAPI"></input>
                                        </div>

                                        <div class="col-5">
                                            <label for="api" class="form-label">API</label>
                                            <input class="form-control" id="api" name="api"></input>
                                        </div>
                                        <div class="col-2">
                                            <button style="margin-top: 32px;" class="btn btn-sm btn-danger" type="submit">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr class="sidebar-divider">
                            <?php
                            $sql = "SELECT * FROM integracao_ozmap_api";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $apis = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>

                            <div class="row">
                                <div class="col-lg-6"><b>Descrição API</b></div>
                                <div class="col-lg-6"><b>API</b></div>
                            </div>

                            <?php foreach ($apis as $api) : ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?= $api['descricaoAPI'] ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?= $api['api'] ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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