<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <div class="row">
            <div class="col-lg-8">
                <h1>Cadastro de Consultas</h1>
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
                                <h5 class="card-title">Cadastro</h5>
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
                            <div class="col-8">
                                <label for="consulta_nome" class="form-label">Identificação da Consulta</label>
                                <input type="text" class="form-control" name="consulta_nome" id="consulta_nome">
                            </div>
                            <div class="col-12">
                                <label for="consulta_sql" class="form-label">Consulta SQL</label>
                                <textarea class="form-control" name="consulta_sql" id="consulta_sql" rows="10"></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <input id="btnCriar" name="btnCriar" type="button" value="Criar Consulta" class="btn btn-danger"></input>
                                <input id="btnTestar" name="btnTestar" type="button" value="Testar Consulta" class="btn btn-primary"></input>
                            </div>
                        </form><!-- Vertical Form -->

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


<?php
require "js_nova_consulta.php";
require "../../includes/footer.php";
?>