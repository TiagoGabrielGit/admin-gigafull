<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$usuarioID = $_SESSION['id'];
$idPOP = $_GET['id'];

$menu_id = "6";
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
    $sql_pop =
        "SELECT
    pop.id as id,
    pop.pop as pop,
    pop.apelidoPop as apelidoPop
    FROM pop as pop
    LEFT JOIN pop_address as endereco ON endereco.pop_id = pop.id
    LEFT JOIN empresas as emp ON emp.id = pop.empresa_id
    WHERE pop.active = 1 and pop.id = $idPOP    
    ORDER BY emp.fantasia asc, endereco.city asc, pop.pop asc
";

    $resultado = mysqli_query($mysqli, $sql_pop);
    $row = mysqli_fetch_assoc($resultado);

    $sql_lista_equipamentos =
        "SELECT
    eqp.id as idEqp,
    eqp.hostname as equipamento,
    eqto.equipamento as modelo,
    eqp.statusEquipamento as status
    FROM equipamentospop as eqp
    LEFT JOIN equipamentos as eqto ON eqto.id = eqp.equipamento_id
    WHERE eqp.deleted = 1 and eqp.pop_id LIKE '$idPOP'
    ORDER BY eqp.hostname ASC";

    $r_lista_equipamentos = mysqli_query($mysqli, $sql_lista_equipamentos);
    $r_lista_vistoria_equipamentos = mysqli_query($mysqli, $sql_lista_equipamentos);
    $r2_lista_vistoria_equipamentos = mysqli_query($mysqli, $sql_lista_equipamentos);
?>

    <style>
        /* CSS para mudar a cor de fundo da linha ao passar o mouse */
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            /* Escolha a cor que desejar */
            cursor: pointer;
        }
    </style>

    <main id="main" class="main">

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">POP <?= $row['pop']; ?></h5>

                            <!-- Default Tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="informacoes-tab" data-bs-toggle="tab" data-bs-target="#informacoes" type="button" role="tab" aria-controls="informacoes" aria-selected="true" onclick="window.location.href = 'view_informacoes.php?id=<?= $idPOP ?>';">Informacoes</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="equipamentos-tab" data-bs-toggle="tab" data-bs-target="#equipamentos" type="button" role="tab" aria-controls="equipamentos" aria-selected="false" onclick="window.location.href = 'view_equipamentos.php?id=<?= $idPOP ?>';">Equipamentos</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="energia-tab" data-bs-toggle="tab" data-bs-target="#energia" type="button" role="tab" aria-controls="energia" aria-selected="false" onclick="window.location.href = 'view_energia.php?id=<?= $idPOP ?>';">Energia</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="anexo-tab" data-bs-toggle="tab" data-bs-target="#anexo" type="button" role="tab" aria-controls="anexo" aria-selected="false" onclick="window.location.href = 'view_anexo.php?id=<?= $idPOP ?>';">Anexos</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="atividades-tab" data-bs-toggle="tab" data-bs-target="#atividades" type="button" role="tab" aria-controls="atividades" aria-selected="false" onclick="window.location.href = 'view_atividades.php?id=<?= $idPOP ?>';">Atividades</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="vistoria-tab" data-bs-toggle="tab" data-bs-target="#vistoria" type="button" role="tab" aria-controls="vistoria" aria-selected="false" onclick="window.location.href = 'view_vistoria.php?id=<?= $idPOP ?>';">Vistoria</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2" id="myTabContent">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Equipamentos no POP</h5>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center;" scope="col">Equipamento</th>
                                                        <th style="text-align: center;" scope="col">Modelo</th>
                                                        <th style="text-align: center;" scope="col">Status</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php while ($c_lista_equipamentos = $r_lista_equipamentos->fetch_array()) { ?>
                                                        <tr onclick="window.open('/telecom/sitepop/equipamentos/view.php?id=<?= $c_lista_equipamentos['idEqp'] ?>', '_blank')">
                                                            <td style="text-align: center;"><?= $c_lista_equipamentos['equipamento']; ?></td>
                                                            <td style="text-align: center;"><?= $c_lista_equipamentos['modelo']; ?></td>
                                                            <td style="text-align: center;"><?= $c_lista_equipamentos['status']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div><!-- End Default Tabs -->
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>