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
?>

    <style>
        /* CSS para mudar a cor de fundo da linha ao passar o mouse */
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Contratos</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h5 class="card-title">Lista de Contratos</h5>
                            </div>
                            <div class="col-2">
                                <button style="margin-top: 15px;" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalCadastrarContrato">Criar Novo</button>
                            </div>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr style="text-align: center;">
                                    <th scope="col">ID</th>
                                    <th scope="col">Empresa/Cliente</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                // Consulta para listar os contratos
                                $sql_lista_contratos = "
                                        SELECT
                                            c.id as idContrato,
                                            c.empresa_id as idEmpresa,
                                            c.active as idStatus,
                                            e.fantasia as fantasia,
                                            CASE
                                                WHEN c.active = 1 THEN 'Ativo'
                                                WHEN c.active = 0 THEN 'Inativo'
                                            END as active
                                        FROM
                                            contract as c
                                        LEFT JOIN
                                            empresas as e ON e.id = c.empresa_id
                                        ORDER BY fantasia ASC
                                    ";

                                $stmt_contratos = $pdo->prepare($sql_lista_contratos);
                                $stmt_contratos->execute();

                                while ($c_lista_contratos = $stmt_contratos->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr style="vertical-align: middle; text-align: center;" onclick="window.location.href='view_info.php?id=<?= $c_lista_contratos['idContrato'] ?>'">
                                        <td><?= $c_lista_contratos['idContrato']; ?></td>
                                        <td><?= $c_lista_contratos['fantasia']; ?></td>
                                        <td><?= $c_lista_contratos['active']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="modalCadastrarContrato" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Contrato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">

                        <form action="processa/novo_contrato.php" method="POST" class="row g-3">
                            <div class="col-6">
                                <label for="empresa" class="form-label">Empresa</label>
                                <select required class="form-select" id="empresa" name="empresa">
                                    <option disabled value="" selected>Selecione uma opção</option>
                                    <?php
                                    $sql_empresas = "SELECT id, fantasia FROM empresas WHERE deleted = 1 ORDER BY fantasia ASC";
                                    $stmt = $pdo->prepare($sql_empresas);
                                    $stmt->execute();

                                    while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . htmlspecialchars($empresa['id']) . '">' . htmlspecialchars($empresa['fantasia']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="text-center">
                                <button class="btn btn-sm btn-danger" type="submit">Criar Novo Contrato</button>
                            </div>
                        </form>

                    </div>
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