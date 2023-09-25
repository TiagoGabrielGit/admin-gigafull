<div class="row">
    <div class="col-lg-10">
        <h5 class="card-title">Templates de Comunicação via E-mail</h5>
    </div>
    <div class="col-lg-2" style="margin-top: 10px;">
        <a href="/comunicacao/templates/novo.php" class="btn btn-sm btn-danger">Criar Novo</a>
    </div>
</div>

<?php
if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'];

    if ($errorMessage === 'codigo_ja_existe') {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo 'A OLT já esta cadastrado no banco de dados.';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}
?>

<hr class="sidebar-divider">
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <table class="table datatable" id="styleTable">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Aplicado em</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql =
                        "SELECT
                        ct.id as id,
                        ct.titulo as titulo,
                        ct.template as template,
                        CASE
                            WHEN ct.aplicado = 1 THEN 'Incidentes'
                            WHEN ct.aplicado = 2 THEN 'Manutenção Programada'
                        END as aplicado,
                        CASE
                            WHEN ct.active = 1 THEN 'Ativo'
                            WHEN ct.active = 0 THEN 'Inativo'
                        END as active
                    FROM comunicacao_templates as ct
                    WHERE ct.tipo = 1
                    ORDER BY ct.template ASC";

                    $r_sql = mysqli_query($mysqli, $sql);

                    while ($c_sql = $r_sql->fetch_array()) {
                    ?>
                        <tr id="tabelaLista" onclick="location.href='view.php?id=<?= $c_sql['id'] ?>'">
                            <td><?= $c_sql['id']; ?></td>
                            <td><?= $c_sql['titulo']; ?></td>
                            <td><?= $c_sql['aplicado']; ?></td>
                            <td><?= $c_sql['active']; ?></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdicionarOLTs" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar OLTs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <form action="processa/adicionar_olts.php" method="POST" class="row g-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="equipamento" class="form-label">Equipamento*</label>
                                <select class="form-select" id="equipamento" name="equipamento" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <?php
                                    $sql_equipamento =
                                        "SELECT
                                        eqp.hostname as equipamento_name,
                                        eqp.id as equipamento_id
                                        FROM
                                        equipamentospop as eqp
                                        WHERE
                                        eqp.deleted = 1
                                        AND
                                        eqp.tipoEquipamento_id = 5
                                        ORDER BY
                                        eqp.hostname ASC";

                                    $r_equipamento = mysqli_query($mysqli, $sql_equipamento);

                                    while ($c_equipamento = mysqli_fetch_object($r_equipamento)) :
                                        echo "<option value='$c_equipamento->equipamento_id'> $c_equipamento->equipamento_name</option>";
                                    endwhile;
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="identificacao" class="form-label">Identificação*</label>
                                <input id="identificacao" name="identificacao" class="form-control" type="text" required></input>
                            </div>
                            <div class="col-6">
                                <label for="cidade" class="form-label">Cidade*</label>
                                <input id="cidade" name="cidade" class="form-control" type="text" required></input>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label for="usuarioIntegracao" class="form-label">Usuário Integração</label>
                                <input id="usuarioIntegracao" name="usuarioIntegracao" class="form-control" type="text"></input>

                            </div>
                            <div class="col-6">
                                <label for="senhaIntegracao" class="form-label">Senha</label>
                                <input id="senhaIntegracao" name="senhaIntegracao" class="form-control" type="text"></input>
                            </div>
                        </div>
                        <hr class="sidebar-divider">

                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>