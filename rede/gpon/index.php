<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
$uid = $_SESSION['id'];

$submenu_id = "32";

$permissions =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();
$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>GPON</h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <?php
                    if (isset($_GET['error'])) {
                        $errorMessage = $_GET['error'];

                        if ($errorMessage === 'codigo_ja_existe') {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo 'A OLT já esta cadastrado no banco de dados.';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        }
                    }
                    ?>

                    <div class="row">
                        <div class="col-lg-10">
                            <h5 class="card-title">OLTs</h5>
                        </div>
                        <div class="col-lg-2" style="margin-top: 10px;">
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalAdicionarOLTs">Adicionar</button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;" scope="col">OLT</th>
                                <th style="text-align: center;" scope="col">Cidade</th>
                                <th style="text-align: center;" scope="col">Status</th>
                                <th style="text-align: center;" scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_lista_olts =
                                "SELECT
                        gpo.id as id,
                        gpo.olt_name as olt,
                        gpo.city as city,
                        CASE
                            WHEN gpo.active = 1 THEN 'Ativo'
                            WHEN gpo.active = 0 THEN 'Inativo'
                        END as active
                    FROM gpon_olts as gpo
                    ORDER BY gpo.olt_name ASC;";

                            $r_lista_olts = mysqli_query($mysqli, $sql_lista_olts);

                            while ($c_lista_olts = $r_lista_olts->fetch_array()) {
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?= $c_lista_olts['olt']; ?></td>
                                    <td style="text-align: center;"><?= $c_lista_olts['city']; ?></td>
                                    <td style="text-align: center;"><?= $c_lista_olts['active']; ?></td>


                                    <td style="text-align: center;">
                                        <button title="Visualizar OLT" type="button" class="btn btn-sm btn-info" onclick="window.location.href = 'olt_view.php?id=<?= $c_lista_olts['id']; ?>';">
                                            <i class="bi bi-arrow-right-square"></i>
                                        </button>

                                        <button title=" Visualizar PONs" type="button" class="btn btn-sm btn-warning" onclick="window.location.href = '/rede/gpon/pons.php?olt_id=<?= $c_lista_olts['id']; ?>';">
                                            <i class="bi bi-bezier"></i>
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
    <div class="modal fade" id="modalAdicionarOLTs" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar OLTs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <form action="processa/adicionar_olts.php" method="POST" class="row g-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="equipamento" class="form-label">Equipamento*</label>
                                    <select class="form-select" id="equipamento" name="equipamento" required>
                                        <option value="" disabled selected>Selecione...</option>
                                        <?php
                                        $sql_equipamento =
                                            "SELECT
                                        eqp.hostname as equipamento_name,
                                        eqp.id as equipamento_id
                                        FROM
                                        equipamentospop as eqp
                                        WHERE
                                        eqp.deleted = 1
                                        AND
                                        eqp.tipoEquipamento_id = 5
                                        ORDER BY
                                        eqp.hostname ASC";

                                        $r_equipamento = mysqli_query($mysqli, $sql_equipamento);

                                        while ($c_equipamento = mysqli_fetch_object($r_equipamento)) :
                                            echo "<option value='$c_equipamento->equipamento_id'> $c_equipamento->equipamento_name</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="identificacao" class="form-label">Identificação*</label>
                                    <input id="identificacao" name="identificacao" class="form-control" type="text" required></input>
                                </div>
                                <div class="col-6">
                                    <label for="cidade" class="form-label">Cidade*</label>
                                    <input id="cidade" name="cidade" class="form-control" type="text" required></input>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="usuarioIntegracao" class="form-label">Usuário Integração</label>
                                    <input id="usuarioIntegracao" name="usuarioIntegracao" class="form-control" type="text"></input>

                                </div>
                                <div class="col-6">
                                    <label for="senhaIntegracao" class="form-label">Senha</label>
                                    <input id="senhaIntegracao" name="senhaIntegracao" class="form-control" type="text"></input>
                                </div>
                            </div>
                            <hr class="sidebar-divider">

                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>