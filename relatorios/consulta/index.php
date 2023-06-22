<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$sql_consultas =
    "SELECT
    id as 'id',
    consulta_identificacao as 'consulta_identificacao'
    FROM consultas_sql as cs
    where
    active = 1
    order by
    consulta_identificacao ASC";

$stmt = $pdo->query($sql_consultas);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Consultas</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gerador de Relatórios</h5>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <select class="form-select" id="consulta-select" aria-label="Default select example">
                                    <option disabled value="" selected>Selecione uma consulta</option>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  ?>
                                        <option value="<?= $row['id'] ?>" data-id="<?= $row['id'] ?>"><?= $row['consulta_identificacao'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <button type="submit" id="gerar-relatorio-csv-btn" class="btn btn-danger">Gerar Relatório em CSV</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
require "js_consulta.php";
require "../../includes/footer.php";
?>