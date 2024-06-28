<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Obter o ID do menu e do usuário
$menu_id = "1";
$uid = $_SESSION['id'];

// Consulta para verificar permissões
$permissions = "
    SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = :uid AND pp.url_menu = :menu_id
";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions->bindParam(':menu_id', $menu_id, PDO::PARAM_STR);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {


    $idContrato = $_GET['id'];

    $sql_contrato =
        "SELECT
c.id as idContrato,
c.empresa_id as idEmpresa,
CASE
WHEN active = 1 THEN 'Ativo'
WHEN active = 0 THEN 'Inativo'
END as active,
c.active as idActive,
e.fantasia as fantasia
FROM
contract as c
LEFT JOIN
empresas as e
ON
e.id = c.empresa_id
WHERE
c.id = $idContrato
";

    $r_contrato = mysqli_query($mysqli, $sql_contrato);
    $c_contrato = $r_contrato->fetch_array();

?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Contrato</h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a href="view_info.php?id=<?= $idContrato ?>"><button class="nav-link active" type="button">Informações do Contrato</button></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="view_service.php?id=<?= $idContrato ?>"><button class="nav-link" type="button">Serviços</button></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="view_itemservice.php?id=<?= $idContrato ?>"><button class="nav-link" type="button">Item de Serviço</button></a>
                                            </li>
                                        </ul>

                                        <div class="row">
                                            <div class="col-lg-10">
                                                <h5 class="card-title">Contrato: <?= $c_contrato['idContrato'] ?></h5>
                                            </div>
                                        </div>
                                        <input id="idContrato" value="<?= $c_contrato['idContrato'] ?>" type="text" class="form-control" hidden>
                                        <hr class="sidebar-divider">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-12">

                                                        <form action="processa/update_contrato_informacao.php" method="POST" class="row g-3">

                                                            <input hidden id="contractIDInformation" name="contractIDInformation" value="<?= $idContrato ?>"></input>

                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label class="form-label">Empresa</label>
                                                                    <input value="<?= $c_contrato['fantasia'] ?>" type="text" class="form-control" disabled>
                                                                </div>

                                                                <div class="col-5"></div>
                                                                <div class="col-3">
                                                                    <label for="statusContrato" class="form-label">Status</label>
                                                                    <select class="form-select" id="statusContrato" name="statusContrato" required>
                                                                        <option value="1" <?= $c_contrato['idActive'] == '1' ? 'selected' : ''; ?>>Ativo</option>
                                                                        <option value="0" <?= $c_contrato['idActive'] == '0' ? 'selected' : ''; ?>>Inativo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <hr class="sidebar-divider">

                                                            <div class="text-center">
                                                                <button class="btn btn-sm btn-danger" type="submit">Salvar Alterações</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
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