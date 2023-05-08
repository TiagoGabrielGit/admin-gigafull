<div class="row">
    <div class="col-8">
        <h5 class="card-title">Itens cadastrados</h5>
    </div>

    <div class="col-2"></div>

    <div class="col-2">
        <div class="card">
            <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoItem">
                Novo Item
            </button>
        </div>
    </div>
    <!-- Table with stripped rows -->
    <table class="table table-striped" id="styleTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Item</th>
                <th scope="col">Descrição</th>
                <th scope="col">Código Integração</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $sql_itens_cadastrados =
                "SELECT
                ise.id as idItem,
                ise.item as item,
                ise.integration_code as intCode,
                ise.description as description,
                CASE
                WHEN ise.active = 1 THEN 'Ativo'
                WHEN ise.active = 0 THEN 'Inativo'
                END as active
                FROM
                iten_service as ise
                ";

            $r_itens_cadastrados = mysqli_query($mysqli, $sql_itens_cadastrados);
            while ($c_itens_cadastrados = $r_itens_cadastrados->fetch_array()) { ?>

                <tr>
                    <td><?= $c_itens_cadastrados['idItem']; ?></td>
                    <td><?= $c_itens_cadastrados['item']; ?></td>
                    <td><?= $c_itens_cadastrados['description']; ?></td>
                    <td><?= $c_itens_cadastrados['intCode']; ?></td>
                    <td><?= $c_itens_cadastrados['active']; ?></td>
                    <td>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEditarItem<?= $c_itens_cadastrados['idItem']; ?>">Editar</button>

                        <div class="modal fade" id="modalEditarItem<?= $c_itens_cadastrados['idItem']; ?>" tabindex="-1">
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

                                                <input hidden id="itemID" name="itemID" value="<?= $c_itens_cadastrados['idItem']; ?>"></input>

                                                <div class="col-6">
                                                    <label for="item" class="form-label">Item</label>
                                                    <input type="text" class="form-control" id="item" name="item" value="<?= $c_itens_cadastrados['item']; ?>" required>
                                                </div>

                                                <div class="col-3"></div>

                                                <div class="col-3">
                                                    <label for="activeEditar" class="form-label">Status</label>
                                                    <select class="form-select" id="activeEditar" name="activeEditar" required>
                                                        <option value="1" <?= $c_itens_cadastrados['active'] == 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
                                                        <option value="0" <?= $c_itens_cadastrados['active'] == 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
                                                    </select>
                                                </div>

                                                <div class="col-3">
                                                    <label for="codIntEdit" class="form-label">Código Integração</label>
                                                    <input type="text" class="form-control" id="codIntEdit" name="codIntEdit" value="<?= $c_itens_cadastrados['intCode']; ?>" required>
                                                </div>

                                                <div class="col-9">
                                                    <label for="descricaoItemEdit" class="form-label">Descrição</label>
                                                    <textarea id="descricaoItemEdit" name="descricaoItemEdit" class="form-control" maxlength="100" required><?= $c_itens_cadastrados['description']; ?></textarea>
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
                    </td>

                </tr>
            <?php } ?>

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

                    <form id="formNewItem" method="POST" class="row g-3">
                        <span id="msgCadastroItem"></span>

                        <div class="col-6">
                            <label for="cadItem" class="form-label">Item</label>
                            <input type="text" class="form-control" id="cadItem" name="cadItem" required>
                        </div>

                        <div class="col-3"></div>

                        <div class="col-3">
                            <label for="cadItemCodInt" class="form-label">Código Integração</label>
                            <input type="text" class="form-control" id="cadItemCodInt" name="cadItemCodInt">
                        </div>

                        <div class="col-12">
                            <label for="descricaoItem" class="form-label">Descrição</label>
                            <textarea id="descricaoItem" name="descricaoItem" class="form-control" maxlength="100" required></textarea>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="col-4"></div>

                        <div class="col-4" style="text-align: center;">
                            <input id="btnSalvarItem" name="btnSalvarItem" type="button" value="Salvar" class="btn btn-danger"></input>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>