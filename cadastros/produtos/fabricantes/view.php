<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$SQL =
    "SELECT * 
FROM fabricante 
WHERE id = '$id'
";

$resultado = mysqli_query($mysqli, $SQL);
$row = mysqli_fetch_assoc($resultado);
?>


<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['fabricante']; ?> </h5>

                        <!-- Multi Columns Form -->
                        <form method="POST" action="processa/edit.php" class="row g-3">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="row mb-3">
                                <label for="codigo" class="col-sm-12 col-form-label">Código</label>
                                <div class="col-sm-2">
                                    <input name="codigo" type="text" class="form-control" id="codigo" value="<?php echo $row['id']; ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputFabricante" class="col-sm-12 col-form-label">Fabricante</label>
                                <div class="col-sm-4">
                                    <input name="fabricante" type="text" class="form-control" id="inputFabricante" value="<?php echo $row['fabricante']; ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="dateCreated" class="form-label">Data criação</label>
                                <div class="col-sm-6">
                                    <input name="dateCreated" type="text" class="form-control" id="dateCreated" value="<?php echo $row['criado']; ?>" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="dateModified" class="form-label">última modificação</label>
                                <div class="col-sm-6">
                                    <input name="dateModified" type="text" class="form-control" id="dateModified" value="<?php echo $row['modificado']; ?>" disabled>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">Salvar</button>
                                <input type="button" value="Voltar" onClick="history.go(-1)" class="btn btn-secondary">
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
require "../../../includes/footer.php";
?>