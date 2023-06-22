<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$sql_consultas =
    "SELECT
    id as 'id',
    consulta_identificacao as 'consulta_identificacao',
    CASE
    WHEN active = 1 THEN 'Ativo'
    WHEN active = 0 THEN 'Inativo'
    END as active
    FROM consultas_sql as cs";

$stmt = $pdo->query($sql_consultas);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Cadastro de Consultas</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h5 class="card-title">Consultas</h5>
                            </div>
                            <div class="col-lg-4">
                                <a href="nova_consulta.php">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                        Nova Consulta
                                    </button>
                                </a>
                            </div>
                        </div>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Consulta</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cont = 1;
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  ?>
                                    <tr>
                                        <th scope="row"><?= $cont ?></th>
                                        <td><a style="color: red;" href="editar.php?id=<?= $row['id'] ?>"><?= $row['consulta_identificacao'] ?></a></td>
                                        <td><?= $row['active'] ?></td>
                                    </tr>
                                <?php $cont++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
require "../../includes/footer.php";
?>