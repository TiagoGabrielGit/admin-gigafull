<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";
$uid = $_SESSION['id'];

$submenu_id = "55";

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

    <?php
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql_status =
        "SELECT
        cs.id as id_status,
        cs.status_chamado as status_chamado,
        cs.color as color,
        CASE
        WHEN cs.cadastroDefault = 1 THEN 'Sim'
        WHEN cs.cadastroDefault = 0 THEN 'Não'
        END as cadastroDefault,
        cs.active  as active_status
        FROM chamados_status as cs
        WHERE cs.id = $id
";

    $r_status = mysqli_query($mysqli, $sql_status) or die("Erro ao retornar dados");
    $c_status = $r_status->fetch_array();

    if ($c_status['active_status'] == 1) {
        $checkSituacao1 = "checked";
        $checkSituacao0 = "";
    } else if ($c_status['active_status'] == 0) {
        $checkSituacao0 = "checked";
        $checkSituacao1 = "";
    }
    ?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Status de Chamado</h5>

                                        <form method="POST" action="processa/editar.php" class="row g-3">
                                            <input type="hidden" name="id" value="<?= $id ?>">

                                            <hr class="sidebar-divider">

                                            <div class="col-lg-8">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label for="codigo" class="form-label">Código</label>
                                                        <input readonly name="codigo" type="text" class="form-control" id="codigo" value="<?= $id ?>">
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="statusChamado" class="form-label">Status</label>
                                                        <input name="statusChamado" type="text" class="form-control" id="statusChamado" value="<?= $c_status['status_chamado']; ?>">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="colorStatus" class="form-label">Cor Referência</label>
                                                        <input type="color" class="form-control form-control-color" name="colorStatus" id="colorStatus" value="<?= $c_status['color'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="col-12">
                                                    <label for="situacao" class="form-label">Situação</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="situacao" id="situacaoAtivo" value="1" <?= $checkSituacao1 ?>>
                                                        <label class="form-check-label" for="situacaoAtivo">
                                                            Ativo
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="situacao" id="situacaoInativo" value="0" <?= $checkSituacao0 ?>>
                                                        <label class="form-check-label" for="situacaoInativo">
                                                            Inativo
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="sidebar-divider">

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-sm btn-danger">Salvar Alterações</button>
                                                <a href="/servicedesk/tipos_chamados/status/index.php"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->



<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php"; ?>