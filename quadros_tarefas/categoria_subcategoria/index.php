<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


$submenu_id = "62";
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
            /* Escolha a cor que desejar */
            cursor: pointer;
        }
    </style>

    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>Categoria e Subcategoria</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <br>
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-categorias-tab" data-bs-toggle="pill" data-bs-target="#v-pills-categorias" type="button" role="tab" aria-controls="v-pills-categorias" aria-selected="true" tabindex="-1">Categorias</button>
                            <button class="nav-link" id="v-pills-subcategoria-tab" data-bs-toggle="pill" data-bs-target="#v-pills-subcategoria" type="button" role="tab" aria-controls="v-pills-subcategoria" aria-selected="false" tabindex="-1">Subcategorias</button>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade active show" id="v-pills-categorias" role="tabpanel" aria-labelledby="v-pills-categorias-tab">
                                <div class="row">
                                    <div class="col-10"></div>
                                    <div class="col-2">
                                        <button style="margin-top: 15px; width: 100%;" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalAdicionarCategoria">Adicionar Categoria</button>
                                        <br><br><br>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive w-100">
                                        <table class="table w-100 table-striped table-hover" style="table-layout: fixed; width: 100%;">
                                            <thead>
                                                <tr style="text-align: center;">
                                                    <th style="width: 50%;">Categoria</th>
                                                    <th style="width: 50%;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $busca_categorias =
                                                    "SELECT
                                                    qtc.id as id_categoria, 
                                                qtc.descricao as descricao,
                                                CASE
                                                WHEN qtc.active = 1 THEN 'Ativo'
                                                WHEN qtc.active = 0 THEN 'Inativo'
                                                END as active
                                                FROM qt_categorias as qtc";
                                                $result = $pdo->query($busca_categorias);

                                                if ($result) {
                                                    while ($categoria = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <tr style="text-align: center;" onclick="window.location.href='view_categoria.php?id=<?= htmlspecialchars($categoria['id_categoria']) ?>'">
                                                            <td><?= htmlspecialchars($categoria['descricao']) ?></td>
                                                            <td><?= htmlspecialchars($categoria['active']) ?></td>
                                                        </tr>
                                                <?php }
                                                } else {
                                                    echo "<tr><td colspan='2'>Nenhuma categoria encontrada.</td></tr>"; // Ajustei colspan para 2 colunas
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="v-pills-subcategoria" role="tabpanel" aria-labelledby="v-pills-subcategoria-tab">

                                <div class="row">
                                    <div class="col-10"></div>
                                    <div class="col-2">
                                        <button style="margin-top: 15px; width: 100%;" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalAdicionarSubcategoria">Adicionar Subcategoria</button>
                                        <br><br><br>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Ajustar o estilo para largura total -->
                                    <div class="table-responsive w-100">
                                        <table class="table w-100 table-striped table-hover" style="table-layout: fixed; width: 100%;">
                                            <thead>
                                                <tr style="text-align: center;">
                                                    <th style="width: 50%;">Categoria</th>
                                                    <th style="width: 50%;">Subcategoria</th>
                                                    <th style="width: 50%;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $busca_subcategorias =
                                                    "SELECT 
                                                qts.id as id_subcategoria,
                                                qts.descricao as subcategoria,
                                                qtc.descricao as categoria,
                                                CASE
                                                WHEN qts.active = 1 THEN 'Ativo'
                                                WHEN qts.active = 0 THEN 'Inativo'
                                                END as active
                                                FROM qt_subcategoria as qts
                                                LEFT JOIN qt_categorias as qtc ON qtc.id = qts.id_categoria";
                                                $result = $pdo->query($busca_subcategorias);

                                                if ($result) {
                                                    while ($subcategoria = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <tr style="text-align: center;" onclick="window.location.href='view_subcategoria.php?id=<?= htmlspecialchars($subcategoria['id_subcategoria']) ?>'">
                                                            <td><?= htmlspecialchars($subcategoria['categoria']) ?></td>
                                                            <td><?= htmlspecialchars($subcategoria['subcategoria']) ?></td>
                                                            <td><?= htmlspecialchars($subcategoria['active']) ?></td>
                                                        </tr>
                                                <?php }
                                                } else {
                                                    echo "<tr><td colspan='2'>Nenhuma subcategoria encontrada.</td></tr>"; // Ajustei colspan para 2 colunas
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Vertical Pills Tabs -->

                </div>
            </div>

        </section>
    </main>

    <div class="modal fade" id="modalAdicionarCategoria" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="processa/adicionar_categoria.php">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="categoria">Categoria</label>
                                <input required id="categoria" name="categoria" class="form-control">
                            </div>
                            <div class="col-6">
                                <button style="margin-top: 32px;" class="btn btn-sm btn-danger" type="submit">Adicionar Categoria</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAdicionarSubcategoria" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Subcategoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="processa/adicionar_subcategoria.php">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="categoria_id">Categoria</label>
                                <select required class="form-select" id="categoria_id" name="categoria_id">
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <?php
                                    $stmt = $pdo->query("SELECT id, descricao FROM qt_categorias where active = 1 order by descricao ASC");

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value=\"{$row['id']}\">{$row['descricao']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="subcategoria">Subcategoria</label>
                                <input required class="form-control" id="subcategoria" name="subcategoria">
                            </div>
                            <div class="col-6">
                                <button style="margin-top: 32px;" class="btn btn-sm btn-danger" type="submit">Adicionar Subcategoria</button>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
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