<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


$submenu_id = "8";
$uid = $_SESSION['id'];

$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
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
            <h1>Serviços</h1>
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
                                                <a href="servicos.php"><button class="nav-link ">Serviços</button></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="itens_servicos.php"><button class="nav-link active" type="button">Itens de Serviço</button></a>
                                            </li>
                                        </ul>


                                        <div class="row">
                                            <div class="col-10">
                                                <h5 class="card-title">Itens cadastrados</h5>
                                            </div>

                                            <div class="col-2">
                                                <div class="card">
                                                    <button style="margin-top: 15px" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoItem">
                                                        Novo Item
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Table with stripped rows -->
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr style="text-align: center;">
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Item</th>
                                                        <th scope="col">Descrição</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $sql_itens_cadastrados =
                                                        "SELECT
                ise.id as idItem,
                ise.item as item,
                ise.description as description,
                CASE
                WHEN ise.active = 1 THEN 'Ativo'
                WHEN ise.active = 0 THEN 'Inativo'
                END as active
                FROM
                iten_service as ise
                ";


                                                    $stmt_itens = $pdo->prepare($sql_itens_cadastrados);
                                                    $stmt_itens->execute();

                                                    while ($campos_itensservico = $stmt_itens->fetch(PDO::FETCH_ASSOC)) {
                                                        $idItem = $campos_itensservico['idItem']; ?>
                                                        <tr style="vertical-align: middle; text-align: center;" onclick="window.location.href='view_itemservice.php?id=<?= $campos_itensservico['idItem'] ?>'">
                                                            <td><?= $idItem ?></td>
                                                            <td><?= $campos_itensservico['item']; ?></td>
                                                            <td><?= $campos_itensservico['description']; ?></td>
                                                            <td><?= $campos_itensservico['active']; ?></td>
                                                        </tr>
                                                    <?php }  ?>

                                                </tbody>
                                            </table>
                                            <!-- End Table with stripped rows -->
                                        </div>

                                        <div class="modal fade" id="modalNovoItem" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Novo Item</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="card-body">

                                                            <form action="processa/adiciona_itemservico.php" method="POST" class="row g-3">
                                                                <div class="col-6">
                                                                    <label for="cadItem" class="form-label">Item*</label>
                                                                    <input type="text" class="form-control" id="cadItem" name="cadItem" required>
                                                                </div>

                                                                <div class="col-3"></div>

                                                                <div class="col-12">
                                                                    <label for="descricaoItem" class="form-label">Descrição*</label>
                                                                    <textarea id="descricaoItem" name="descricaoItem" class="form-control" maxlength="100" required></textarea>
                                                                </div>

                                                                <hr class="sidebar-divider">

                                                                <div class="text-center">
                                                                    <button class="btn btn-sm btn-danger" type="submit">Criar Novo Item de Serviço</button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="modalEditarItem" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar Item</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <form id="editarItem" method="POST" class="row g-3">

                                                                <span id="msgEditarItem"></span>

                                                                <input hidden readonly id="itemID" name="itemID"></input>

                                                                <div class="col-6">
                                                                    <label for="itemEditar" class="form-label">Item*</label>
                                                                    <input type="text" class="form-control" id="itemEditar" name="itemEditar" required>
                                                                </div>

                                                                <div class="col-3"></div>

                                                                <div class="col-3">
                                                                    <label for="activeEditarItem" class="form-label">Status*</label>
                                                                    <select id="activeEditarItem" name="activeEditarItem" class="form-select" required>
                                                                        <option selected disabled value="">Selecione</option>
                                                                        <option value='1'> Ativo</option>
                                                                        <option value='0'> Inativo</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-3">
                                                                    <label for="codIntEditar" class="form-label">Código Integração</label>
                                                                    <input type="number" class="form-control" id="codIntEditar" name="codIntEditar" required>
                                                                </div>

                                                                <div class="col-9">
                                                                    <label for="descricaoItemEdit" class="form-label">Descrição*</label>
                                                                    <textarea id="descricaoItemEdit" name="descricaoItemEdit" class="form-control" maxlength="100" required></textarea>
                                                                </div>

                                                                <hr class="sidebar-divider">

                                                                <div class="col-4"></div>

                                                                <div class="col-4" style="text-align: center;">
                                                                    <input id="btnEditarItem" name="btnEditarItem" type="button" value="Editar" class="btn btn-danger"></input>

                                                                </div>

                                                                <div class="col-4"></div>
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