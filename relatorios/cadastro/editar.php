<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_consulta = $_GET['id'];

    $sql_consulta =
        "SELECT
    id as 'id',
    consulta_identificacao as 'consulta_identificacao',
    consulta_sql as 'consulta_sql',
    CASE
    WHEN active = 1 THEN 'Ativo'
    WHEN active = 0 THEN 'Inativo'
    END as active,
    active as activeID
    FROM consultas_sql as cs
    WHERE
    id = $id_consulta";

    $stmt = $pdo->query($sql_consulta);
    $consulta = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = $consulta['id'];
    $consulta_identificacao = $consulta['consulta_identificacao'];
    $consulta_sql = $consulta['consulta_sql'];
?>


    <main id="main" class="main">

        <div class="pagetitle">
            <div class="row">
                <div class="col-lg-8">
                    <h1>Editor de Consultas</h1>
                </div>
            </div>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5 class="card-title">Todas Consultas</h5>
                                </div>
                                <div class="col-lg-4">
                                    <a href="index.php">
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                            Todas Consultas
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <!-- Vertical Form -->
                            <form id="formConsultaSQL" class="row g-3">
                                <span id="msgError"></span>
                                <input hidden readonly value="<?= $id ?>" id="idConsulta" name="idConsulta"></input>
                                <div class="col-8">
                                    <label for="consulta_nome" class="form-label">Identificação da Consulta</label>
                                    <input value="<?= $consulta_identificacao ?>" type="text" class="form-control" name="consulta_nome" id="consulta_nome">
                                </div>

                                <div class="col-4">
                                    <fieldset class="row mb-3">
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="statusConsulta" id="gridRadios1" value="1" <?= $consulta['activeID'] == 1 ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Ativo
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="statusConsulta" id="gridRadios2" value="0" <?= $consulta['activeID'] == 0 ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="gridRadios2">
                                                    Inativo
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-12">
                                    <label for="consulta_sql" class="form-label">Consulta SQL</label>
                                    <textarea class="form-control" name="consulta_sql" id="consulta_sql" rows="10"><?= $consulta_sql ?></textarea>
                                </div>
                                <div class="col-12 text-center">
                                    <input id="btnEditar" name="btnEditar" type="button" value="Editar Consulta" class="btn btn-danger"></input>
                                    <input id="btnTestar" name="btnTestar" type="button" value="Testar Consulta" class="btn btn-primary"></input>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>


                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5 class="card-title">Resultado Teste</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <textarea readonly class="form-control" name="btnTestar" id="resultado_teste" rows="18"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

<?php }
?>

<?php
require "js_editar_consulta.php";
require "../../includes/footer.php";
?>