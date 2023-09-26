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