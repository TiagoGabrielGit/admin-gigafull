<div class="row">
    <div class="col-8">
        <h5 class="card-title">Serviços cadastrados</h5>
    </div>

    <div class="col-2"></div>

    <div class="col-2">
        <div class="card">
            <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoServico">
                Novo Serviço
            </button>
        </div>
    </div>
    <!-- Table with stripped rows -->
    <table class="table table-striped" id="styleTable">
        <thead>
            <tr>
                <th scope="col">Código Serviço</th>
                <th scope="col">Serviço</th>
                <th scope="col">Descrição</th>
                <th scope="col">Item de Serviço</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $sql_view_servicos =
                "SELECT
                                                s.id as idServico,
                                                s.service as service,
                                                s.description as descricao,
                                                s.item_service as item_service,
                                                CASE
                                                    WHEN s.item_service = '1' THEN 'Sim'
                                                    WHEN s.item_service = '0' THEN 'Não'
                                                END as item,
                                                CASE
                                                    WHEN s.active = '1' THEN 'Ativo'
                                                    WHEN s.active = '0' THEN 'Inativo'
                                                END as active
                                            FROM
                                                service as s";

            $resultado_sql_servicos = mysqli_query($mysqli, $sql_view_servicos);
            while ($campos_servico = $resultado_sql_servicos->fetch_array()) {
                $idServico = $campos_servico['idServico']; ?>

                <tr>
                    <td><?= $idServico ?></th>
                    <td><?= $campos_servico['service']; ?></td>
                    <td><?= $campos_servico['descricao']; ?></td>
                    <td><?= $campos_servico['item']; ?></td>
                    <td><?= $campos_servico['active']; ?></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-editar" data-bs-toggle="modal" data-bs-target="#modalEditar" data-id="<?= $idServico ?>" data-service="<?= $campos_servico['service']; ?>" data-descricao="<?= $campos_servico['descricao']; ?>" data-item-service="<?= $campos_servico['item_service']; ?>" data-active="<?= $campos_servico['active']; ?>">
                            Editar
                        </button>
                    </td>

                </tr>
            <?php } ?>

        </tbody>
    </table>
    <!-- End Table with stripped rows -->
</div>


<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <form id="editarService" method="POST" class="row g-3">

                        <span id="msgEditar"></span>

                        <input readonly hidden id="serviceID" name="serviceID" value=""></input>

                        <div class="col-6">
                            <label for="servicoEditar" class="form-label">Serviço</label>
                            <input type="text" class="form-control" id="servicoEditar" name="servicoEditar" value="" required>
                        </div>

                        <div class="col-3">
                            <label for="itemEdit" class="form-label">Permite Item</label>
                            <select class="form-select" id="itemEdit" name="itemEdit" required>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="activeEditar" class="form-label">Status</label>
                            <select class="form-select" id="activeEditar" name="activeEditar" required>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="descricaoEditar" class="form-label">Descrição</label>
                            <textarea id="descricaoEditar" name="descricaoEditar" class="form-control" maxlength="100" required></textarea>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="col-4"></div>

                        <div class="col-4" style="text-align: center;">
                            <input id="btnEditarServico" name="btnEditarServico" type="button" value="Salvar" class="btn btn-danger"></input>
                        </div>

                        <div class="col-4"></div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNovoServico" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">

                    <form id="formNewService" method="POST" class="row g-3">
                        <span id="msgCadastro"></span>

                        <div class="col-6">
                            <label for="servico" class="form-label">Serviço</label>
                            <input type="text" class="form-control" id="servico" name="servico" required>
                        </div>

                        <div class="col-3"></div>
                        <div class="col-3">
                            <label for="item_service" class="form-label">Item de Serviço</label>
                            <select id="item_service" name="item_service" class="form-select" required>
                                <option selected disabled value="">Selecione</option>
                                <option value='1'> Sim</option>
                                <option value='0'> Não</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea id="descricao" name="descricao" class="form-control" maxlength="100" required></textarea>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="col-4"></div>

                        <div class="col-4" style="text-align: center;">
                            <input id="btnSalvarService" name="btnSalvarService" type="button" value="Salvar" class="btn btn-danger"></input>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>