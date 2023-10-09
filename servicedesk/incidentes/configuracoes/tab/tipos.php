<div class="row">
    <div class="col-lg-10">
        <h5 class="card-title">Tipos de Incidentes</h5>
    </div>
    <div class="col-lg-2" style="margin-top: 10px;">
        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalCadastrarTipos">Cadastrar</button>
    </div>
</div>

<?php
if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'];

    // Exibe a mensagem de erro dentro do elemento <div> de alerta
    if ($errorMessage === 'codigo_ja_existe') {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo 'O código já esta cadastrado no banco de dados.';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}
?>

<hr class="sidebar-divider">
<div class="row">
    <div class="col-lg-12">
        <div class="row">

            <table class="table table-striped" id="styleTable">
                <thead>
                    <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Código</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_lista_tipos =
                        "SELECT
                        it.id as id,
                        it.type as tipo,
                        it.codigo as codigo,
                        it.default as `default`,
                        CASE
                        WHEN it.active = 1 THEN 'Ativo'
                        WHEN it.active = 0 THEN 'Inativo'
                        END as active
                        FROM
                        incidentes_types as it
                        ORDER BY
                        it.type ASC
                        ";

                    $r_lista_tipos = mysqli_query($mysqli, $sql_lista_tipos);

                    while ($c_lista_tipos = $r_lista_tipos->fetch_array()) {
                    ?>
                        <tr>
                            <td style="vertical-align: middle;"><?= $c_lista_tipos['tipo']; ?></td>
                            <td style="vertical-align: middle;"><?= $c_lista_tipos['codigo']; ?></td>
                            <td style="vertical-align: middle;"><?= $c_lista_tipos['active']; ?></td>

                            <td style="vertical-align: middle;">
                                <?php if ($c_lista_tipos['default'] == 0) { ?>

                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEditarTipo<?= $c_lista_tipos['id']; ?>">Editar</button>

                                    <div class="modal fade" id="modalEditarTipo<?= $c_lista_tipos['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Editar Tipo de Incidente</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <form action="/servicedesk/incidentes/configuracoes/processa/editarTipoIncidente.php" method="POST" class="row g-3">

                                                            <input hidden id="tipoID" name="tipoID" value="<?= $c_lista_tipos['id']; ?>"></input>

                                                            <div class="col-6">
                                                                <label for="tipoIncidenteEditar" class="form-label">Tipo</label>
                                                                <input type="text" class="form-control" id="tipoIncidenteEditar" name="tipoIncidenteEditar" value="<?= $c_lista_tipos['tipo']; ?>" required>
                                                            </div>
                                                            <div class="col-2"></div>
                                                            <div class="col-4">
                                                                <label for="ativoTipoEditar" class="form-label">Status</label>
                                                                <select class="form-select" id="ativoTipoEditar" name="ativoTipoEditar" required>
                                                                    <option value="1" <?= $c_lista_tipos['active'] == 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
                                                                    <option value="0" <?= $c_lista_tipos['active'] == 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="codigoIncidenteEditar" class="form-label">Código</label>
                                                                <input type="number" class="form-control" id="codigoIncidenteEditar" name="codigoIncidenteEditar" value="<?= $c_lista_tipos['codigo']; ?>" required>
                                                            </div>

                                                            <hr class="sidebar-divider">
                                                            <div class="text-center">
                                                                <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                                                                <button type="reset" class="btn btn-sm btn-secondary">Limpar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </td>


                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCadastrarTipos" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Tipo de Incidente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <form action="/servicedesk/incidentes/configuracoes/processa/cadastrarTipoIncidente.php" method="POST" class="row g-3">

                        <span id="msgSalvarTipo"></span>

                        <div class="col-6">
                            <label for="tipoIncidente" class="form-label">Tipo de Incidente</label>
                            <input type="text" class="form-control" id="tipoIncidente" name="tipoIncidente" required>
                        </div>

                        <div class="col-4">
                            <label for="codigoTipoIncidente" class="form-label">Código</label>
                            <input type="number" class="form-control" id="codigoTipoIncidente" name="codigoTipoIncidente" required>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                            <button type="reset" class="btn btn-sm btn-secondary">Limpar</button>
                        </div>

                    </form><!-- End Horizontal Form -->
                </div>
            </div>
        </div>
    </div>
</div>