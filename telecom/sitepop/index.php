<?php
require "../../includes/menu.php";
require "sql.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>POP / SITE</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Listagem de POPs</h5>
                        <p>Listagem completa de POPs</p>
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true" style="width: 6.211180124223603%;"><a href="#" class="datatable-sorter">#</a></th>

                                            <th data-sortable="true" style="width: 36.43892339544513%;">
                                                <a href="#" class="datatable-sorter">POP</a>
                                            </th>
                                            <th data-sortable="true" style="width: 27.74327122153209%;">
                                                <a href="#" class="datatable-sorter">Empresa</a>
                                            </th>

                                            <th data-sortable="true" style="width: 10.351966873706004%;"><a href="#" class="datatable-sorter">Cidade</a></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- Preenchendo a tabela com os dados do banco: -->
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_lista_pops) or die("Erro ao retornar dados");

                                        // Obtendo os dados por meio de um loop while
                                        while ($campos = $resultado->fetch_array()) {
                                            $id = $campos['id']; ?>
                                            <tr data-index="<?= $id ?>">
                                                <td><?= $id ?></td>
                                                <td><a href="view.php?id=<?= $id ?>"><span style="color: red;"><?= $campos['pop']; ?></span></a></td>
                                                <td><?= $campos['empresa']; ?></td>
                                                <td><?= $campos['cidade']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<?php
require "../../includes/footer.php";
?>