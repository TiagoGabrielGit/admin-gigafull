<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$menu_id = "1";
$uid = $_SESSION['id'];
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
        "SELECT c.id as idContrato, c.empresa_id as idEmpresa,
            CASE
            WHEN active = 1 THEN 'Ativo'
            WHEN active = 0 THEN 'Inativo'
            END as active,
            c.active as idActive,
            e.fantasia as fantasia
            FROM contract as c
            LEFT JOIN empresas as e ON e.id = c.empresa_id
            WHERE c.id = $idContrato
            ";

    $r_contrato = mysqli_query($mysqli, $sql_contrato);
    $c_contrato = $r_contrato->fetch_array();

?>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>

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
                                                <a href="view_info.php?id=<?= $idContrato ?>"><button class="nav-link" type="button">Informações do Contrato</button></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="view_service.php?id=<?= $idContrato ?>"><button class="nav-link" type="button">Serviços</button></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="view_itemservice.php?id=<?= $idContrato ?>"><button class="nav-link active" type="button">Item de Serviço</button></a>
                                            </li>
                                        </ul>
                                        <br>
                                        <div class="row">
                                            <div class="col-9">
                                            </div>
                                            <div class="col-3">
                                                <br>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalAdicionarItem">
                                                    Adicionar Item de Serviço
                                                </button>
                                            </div>
                                        </div>
                                        <br>

                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Serviço</th>
                                                    <th scope="col">Item de Serviço</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $sql_contract_iten_service =
                                                    "SELECT cis.id as idCIS, s.service as service, isr.item as iten,
                                                    CASE
                                                    WHEN  cis.active = 1 THEN 'Ativo'
                                                    WHEN  cis.active = 1 THEN 'Inativo' 
                                                    END as active
                                                    FROM contract_iten_service as cis
                                                    LEFT JOIN contract_service as  cs ON cs.id = cis.contract_service_id
                                                    LEFT JOIN service as s ON s.id = cs.service_id
                                                    LEFT JOIN iten_service as isr ON isr.id = cis.iten_service
                                                    WHERE cs.contract_id = $idContrato";

                                                $r_contract_iten_service = mysqli_query($mysqli, $sql_contract_iten_service);
                                                while ($c_contract_iten_service = $r_contract_iten_service->fetch_array()) { ?>

                                                    <tr>
                                                        <td><?= $c_contract_iten_service['idCIS']; ?></td>
                                                        <td><?= $c_contract_iten_service['service']; ?></td>
                                                        <td><?= $c_contract_iten_service['iten']; ?></td>
                                                        <td><?= $c_contract_iten_service['active']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>


                                        <div class="modal fade" id="modalAdicionarItem" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Adicionar Item ao Serviço</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <form action="processa/adiciona_contrato_itemservico.php" method="POST" class="row g-3">
                                                                <input hidden id="itemContratoID" name="itemContratoID" value="<?= $c_contrato['idContrato']; ?>"></input>

                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        <div class="col-12">
                                                                            <label for="selectService" class="form-label">Serviço</label>
                                                                            <select id="selectService" name="selectService" class="form-select" required>
                                                                                <option selected disabled value="">Selecione</option>
                                                                                <?php
                                                                                $sql_services_item =
                                                                                    "SELECT cs.id as idContractService, s.service as service
                                                                                        FROM contract_service as cs
                                                                                        LEFT JOIN service as s on s.id = cs.service_id
                                                                                        WHERE 
                                                                                        cs.contract_id = $idContrato and s.item_service = 1 and cs.active = 1
                                                                                        ORDER BY s.service ASC";

                                                                                $r_services_item = mysqli_query($mysqli, $sql_services_item);
                                                                                while ($c_services_item = mysqli_fetch_object($r_services_item)) :
                                                                                    echo "<option value='$c_services_item->idContractService'> $c_services_item->service</option>";
                                                                                endwhile;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-5">
                                                                        <div class="col-12">
                                                                            <label for="itemService" class="form-label">Item de Serviço</label>
                                                                            <select id="itemService" name="itemService" class="form-select" required>
                                                                                <option selected disabled value="">Selecione</option>
                                                                                <?php
                                                                                $sql_itens =
                                                                                    "SELECT ise.id as idIten, ise.item as iten
                                                                                    FROM iten_service as ise
                                                                                    WHERE ise.active = 1
                                                                                    ORDER BY ise.item ASC";

                                                                                $r_itens = mysqli_query($mysqli, $sql_itens);
                                                                                while ($c_itens = mysqli_fetch_object($r_itens)) :
                                                                                    echo "<option value='$c_itens->idIten'> $c_itens->iten</option>";
                                                                                endwhile;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <hr class="sidebar-divider">

                                                                <div class="text-center">
                                                                    <button class="btn btn-sm btn-danger" type="submit">Adicionar Item de Serviço</button>
                                                                </div>
                                                            </form><!-- End Horizontal Form -->
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
            </div>
        </section>
    </main>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>