<div class="row">
    <div class="col-lg-10">
        <h5 class="card-title">Lista de Classificações</h5>
    </div>
    <div class="col-lg-2" style="margin-top: 10px;">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCadastrar">Cadastrar</button>
    </div>
</div>

<hr class="sidebar-divider">
<div class="row">
    <div class="col-lg-12">
        <div class="row">

            <table class="table table-striped" id="styleTable">
                <thead>
                    <tr>
                        <th scope="col">Classificação</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_lista_classificacao =
                        "SELECT
                        ic.id as id,
                        ic.classificacao as classificacao,
                        ic.descricao as descricao,
                        CASE
                        WHEN ic.active = 1 THEN 'Ativo'
                        WHEN ic.active = 0 THEN 'Inativo'
                        END as active
                        
                        FROM
                        incidentes_classificacao as ic
                        ORDER BY
                        ic.classificacao ASC
                        ";

                    $r_lista_classificacao = mysqli_query($mysqli, $sql_lista_classificacao);

                    while ($c_lista_classificacao = $r_lista_classificacao->fetch_array()) {
                    ?>
                        <tr>
                            <td><?= $c_lista_classificacao['classificacao']; ?></td>

                            <td><?= $c_lista_classificacao['descricao']; ?></td>
                            <td><?= $c_lista_classificacao['active']; ?></td>

                            <td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $c_lista_classificacao['id']; ?>">Editar</button>

                                <div class="modal fade" id="modalEditar<?= $c_lista_classificacao['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Editar Classificação</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form action="/servicedesk/incidentes/configuracoes/processa/editarClassificacao.php" method="POST" class="row g-3">

                                                        <input hidden id="classificacaoID" name="classificacaoID" value="<?= $c_lista_classificacao['id']; ?>"></input>

                                                        <div class="col-6">
                                                            <label for="classificacaoIncidenteEditar" class="form-label">Classificação</label>
                                                            <input type="text" class="form-control" id="classificacaoIncidenteEditar" name="classificacaoIncidenteEditar" value="<?= $c_lista_classificacao['classificacao']; ?>" required>
                                                        </div>
                                                        <div class="col-2"></div>
                                                        <div class="col-4">
                                                            <label for="ativoClassificacaoEditar" class="form-label">Status</label>
                                                            <select class="form-select" id="ativoClassificacaoEditar" name="ativoClassificacaoEditar" required>
                                                                <option value="1" <?= $c_lista_classificacao['active'] == 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
                                                                <option value="0" <?= $c_lista_classificacao['active'] == 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
                                                            </select>
                                                        </div>


                                                        <div class="col-12">
                                                            <label for="descricaoClassificacaoEditar" class="form-label">Descrição</label>
                                                            <textarea id="descricaoClassificacaoEditar" name="descricaoClassificacaoEditar" class="form-control" maxlength="100" required><?= $c_lista_classificacao['descricao']; ?></textarea>
                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-danger">Salvar</button>
                                                            <button type="reset" class="btn btn-secondary">Limpar</button>
                                                        </div>
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
        </div>
    </div>
</div>

<div class="modal fade" id="modalCadastrar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Classificação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <form action="/servicedesk/incidentes/configuracoes/processa/cadastrarClassificacao.php" method="POST" class="row g-3">

                        <div class="col-6">
                            <label for="classificacaoIncidente" class="form-label">Classificação</label>
                            <input type="text" class="form-control" id="classificacaoIncidente" name="classificacaoIncidente" required>
                        </div>

                        <div class="col-12">
                            <label for="descricaoClassificacao" class="form-label">Descrição</label>
                            <textarea id="descricaoClassificacao" name="descricaoClassificacao" class="form-control" maxlength="100" required></textarea>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Salvar</button>
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                        </div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
        </div>
    </div>
</div>