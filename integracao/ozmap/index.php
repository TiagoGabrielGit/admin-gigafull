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
                                    <h5 class="card-title">Vinculo Empresas Smart X Usuario OZ</h5>
                                </div>
                            </div>
                            <div class="row">
                                <hr class="sidebar-divider">

                                <form action="processa/vinculo_empresa_usuario.php" method="POST">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="empresa" class="form-label">Empresa</label>
                                            <select required class="form-select" id="empresa" name="empresa">
                                                <option disabled selected value="">Selecione uma opção</option>
                                                <?php
                                                $query = "SELECT * FROM empresas WHERE deleted = 1 ORDER BY fantasia ASC";
                                                $stmt = $pdo->query($query);

                                                while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                    <option value="<?php echo $empresa['id']; ?>"><?php echo $empresa['fantasia']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>

                                        </div>

                                        <div class="col-5">
                                            <label for="usuarioOZ" class="form-label">Usuário OZ</label>
                                            <input required class="form-control" id="usuarioOZ" name="usuarioOZ"></input>
                                        </div>
                                        <div class="col-2">
                                            <button style="margin-top: 32px;" class="btn btn-sm btn-danger" type="submit">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr class="sidebar-divider">
                            <?php
                            $sql =
                                "SELECT e.fantasia as fantasia, oze.id as id, oze.usuario_oz as usuario_oz
                            FROM integracao_ozmap_empresas as oze
                            LEFT JOIN empresas as e ON e.id = oze.empresa_id
                            ORDER BY e.fantasia ASC";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();
                            $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>
                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Usuário OZ</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($consultas as $consulta) : ?>

                                        <tr>
                                            <td> <?= $consulta['fantasia'] ?></td>
                                            <td> <?= $consulta['usuario_oz'] ?></td>
                                            <td>
                                                <form action="processa/excluir_empresa_usuario.php" method="POST">
                                                    <input type="hidden" name="cadastro_id" value="<?= $consulta['id'] ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>

                            </table>
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