<?php
require "../../../includes/menu.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Serviços</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
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
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Serviço</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $sql_view_servicos =
                                            "SELECT
                                                s.id as idServico,
                                                s.descricao as descricao,
                                                CASE
                                                    WHEN s.servico = '1' THEN 'Prestação de Serviço'
                                                END as servico,
                                                CASE
                                                    WHEN s.active = '1' THEN 'Ativo'
                                                    WHEN s.active = '0' THEN 'Inativo'
                                                END as statusServico
                                            FROM
                                                servicos as s";

                                        $resultado_sql_servicos = mysqli_query($mysqli, $sql_view_servicos);
                                        while ($campos_servico = $resultado_sql_servicos->fetch_array()) {
                                            $idServico = $campos_servico['idServico']; ?>

                                            <tr onclick="location.href='view.php?id=<?= $idServico ?>'">
                                                <td><?= $idServico ?></th>
                                                <td><?= $campos_servico['descricao']; ?></td>
                                                <td><?= $campos_servico['servico']; ?></td>
                                                <td><?= $campos_servico['statusServico']; ?></td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->



<?php
require "modalNovoServico.php";
require "script.php";
require "../../../includes/footer.php";
?>