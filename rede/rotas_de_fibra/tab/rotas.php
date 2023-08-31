<div class="row">
    <div class="col-lg-10">
        <h5 class="card-title">Rotas</h5>
    </div>
    <div class="col-lg-2" style="margin-top: 10px;">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCadastrarRotas">Cadastrar</button>
    </div>
</div>

<?php
if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'];

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
                        <th scope="col">Código</th>

                        <th scope="col">Ponta A</th>
                        <th scope="col">Ponta B</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_lista_rotas =
                        "SELECT
                        rf.id as id,
                        rf.ponta_a as ponta_a,
                        rf.ponta_b as ponta_b,
                        rf.codigo as codigo,
                        CASE
                        WHEN rf.active = 1 THEN 'Ativo'
                        WHEN rf.active = 0 THEN 'Inativo'
                        END as active
                        FROM
                        rotas_fibra as rf
                        ORDER BY
                        rf.ponta_a ASC
                        ";

                    $r_lista_rotas = mysqli_query($mysqli, $sql_lista_rotas);

                    while ($c_lista_rotas = $r_lista_rotas->fetch_array()) {
                    ?>
                        <tr>
                            <td><a href="view.php?id=<?= $c_lista_rotas['id']; ?>"><span style="color: red;"><?= $c_lista_rotas['codigo']; ?></span></a></td>
                            <td><?= $c_lista_rotas['ponta_a']; ?></td>
                            <td><?= $c_lista_rotas['ponta_b']; ?></td>
                            <td><?= $c_lista_rotas['active']; ?></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCadastrarRotas" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar Rota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <form action="processa/cadastrarRotas.php" method="POST" class="row g-3">

                        <div class="row">
                            <div class="col-4">
                                <label for="codigoRota" class="form-label">Código</label>
                                <input type="number" class="form-control" id="codigoRota" name="codigoRota" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label for="pontaA" class="form-label">Ponta A</label>
                                <select class="form-select" id="pontaA" name="pontaA" required>
                                    <option value="" disabled selected>Selecione...</option>

                                    <?php
                                    $sql_pop =
                                        "SELECT
                                                    p.id as idPOP,
                                                    p.pop as pop,
                                                    pa.city
                                                FROM
                                                    pop as p
                                                LEFT JOIN
                                                pop_address as pa
                                                ON
                                                pa.pop_id = p.id    
                                                WHERE
                                                    p.active = 1
                                                ORDER BY
                                                    p.pop ASC";

                                    $r_pop = mysqli_query($mysqli, $sql_pop);
                                    while ($c_pop = mysqli_fetch_object($r_pop)) :
                                        echo "<option value='$c_pop->pop ($c_pop->city)'> $c_pop->pop ($c_pop->city)</option>";
                                    endwhile;
                                    ?>

                                </select>
                            </div>

                            <div class="col-6">
                                <label for="pontaB" class="form-label">Ponta B</label>
                                <select class="form-select" id="pontaB" name="pontaB" required>
                                    <option value="" disabled selected>Selecione...</option>

                                    <?php
                                    $sql_pop =
                                        "SELECT
                                                    p.id as idPOP,
                                                    p.pop as pop,
                                                    pa.city
                                                FROM
                                                    pop as p
                                                LEFT JOIN
                                                pop_address as pa
                                                ON
                                                pa.pop_id = p.id    
                                                WHERE
                                                    p.active = 1
                                                ORDER BY
                                                    p.pop ASC";

                                    $r_pop = mysqli_query($mysqli, $sql_pop);
                                    while ($c_pop = mysqli_fetch_object($r_pop)) :
                                        echo "<option value='$c_pop->pop ($c_pop->city)'> $c_pop->pop ($c_pop->city)</option>";
                                    endwhile;
                                    ?>

                                </select>
                            </div>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Salvar</button>
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>