<div class="row">
    <div class="col-lg-10">
        <h5 class="card-title">OLTs</h5>
    </div>
    <div class="col-lg-2" style="margin-top: 10px;">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalAdicionarOLTs">Adicionar</button>
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
            <table class="table table-striped" id="styleTable">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">OLT</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_lista_olts =
                        "SELECT
                        gpo.id as id,
                        gpo.olt_name as olt,
                        gpo.city as city,
                        CASE
                            WHEN gpo.active = 1 THEN 'Ativo'
                            WHEN gpo.active = 0 THEN 'Inativo'
                        END as active
                    FROM
                        gpon_olts as gpo
                    ORDER BY
                        gpo.olt_name ASC;
                    
                        ";

                    $r_lista_olts = mysqli_query($mysqli, $sql_lista_olts);

                    while ($c_lista_olts = $r_lista_olts->fetch_array()) {
                    ?>
                        <tr>
                            <td><a href="olt_view.php?id=<?= $c_lista_olts['id']; ?>"><span style="color: red;"><?= $c_lista_olts['id']; ?></span></a></td>
                            <td><?= $c_lista_olts['olt']; ?></td>
                            <td><?= $c_lista_olts['city']; ?></td>
                            <td><?= $c_lista_olts['active']; ?></td>
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