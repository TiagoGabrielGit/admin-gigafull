<?php
require "../../includes/menu.php";

$id_Usuario = $_SESSION['id'];
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Documentação</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-lg-9">
                                <h5 class="card-title">Criar Documentação</h5>
                            </div>
                            <div class="col-lg-3">
                                <a href="index.php">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                        Lista Documentações
                                    </button>
                                </a>
                            </div>
                        </div>

                        <form id="formNovoDocument">
                            <input readonly hidden name="idUsuario" id="idUsuario" value="<?= $id_Usuario ?>"></input>

                            <div class="col-6">
                                <label for="titleDocumentation" class="form-label"><b>Titulo</b></label>
                                <input placeholder="Ex: Empresa - Assunto (VOA - Auditoria de Backups)" name="titleDocumentation" type="text" class="form-control" id="titleDocumentation" required>
                            </div>
                            <br>
                            <div class="col-12">
                                <div class="quill-editor-full">
                                </div>
                            </div>
                            <br>
                            <div class="col-12 text-center">
                                <input id="btnCriar" name="btnCriar" type="button" value="Criar Documentação" class="btn btn-danger"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "js_criar.php";
require "../../includes/footer.php";
?>