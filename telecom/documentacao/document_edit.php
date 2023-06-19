<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$document_id = $_GET['id'];
$sql_document = "SELECT * FROM documentation WHERE id = :document_id";

$stmt = $pdo->prepare($sql_document);
$stmt->bindParam(':document_id', $document_id, PDO::PARAM_INT);
$stmt->execute();
$document = $stmt->fetch(PDO::FETCH_ASSOC);
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
                                <h5 class="card-title"><?= $document['title'] ?></h5>
                            </div>
                            <div class="col-lg-3">
                                <a href="index.php">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                        Lista Documentações
                                    </button>
                                </a>
                            </div>
                        </div>

                        <span id="msgEditar"></span>
                        <form id="formDocument">
                            <input readonly hidden id="idDocument" name="idDocument" value="<?= $document_id ?>"></input>
                            <div class="quill-editor-full">
                                <?= $document['document'] ?>
                            </div>
                            <br>
                            <div class="col-12 text-center">
                                <input id="btnEditar" name="btnEditar" type="button" value="Salvar Alterações" class="btn btn-danger"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "js_editar.php";
require "../../includes/footer.php";
?>