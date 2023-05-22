<?php
require "../includes/menu.php";
require "../conexoes/conexao.php";
require "../conexoes/sql.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_estado =
"SELECT
    estado.id as id,
    estado.estado as estado,
    estado.criado as criado,
    estado.modificado as modificado,
    pais.pais as pais,
    pais.id as idpais
FROM
    estado as estado
LEFT JOIN 
    pais as pais
    ON
    pais.id = estado.pais
WHERE 
    estado.deleted = 1
    and
    estado.id = '$id'
ORDER BY 
    pais.pais ASC,
    estado.estado ASC
";

$resultado = mysqli_query($mysqli, $sql_estado);
$row = mysqli_fetch_assoc($resultado);
?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['estado']; ?> - <?php echo $row['pais']; ?></h5>

                        <!-- Multi Columns Form -->
                        <form method="POST" action="/processa_edit/estado.php" class="row g-3">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="row mb-3">
                                <label for="codigo" class="col-sm-12 col-form-label">Código</label>
                                <div class="col-sm-2">
                                    <input name="codigo" type="text" class="form-control" id="codigo" value="<?php echo $row['id']; ?>" disabled>
                                </div>
                            </div>

                            <div class="col mb-4">
                                <label for="inputEstado" class="col-sm-12 col-form-label">Estado</label>
                                <div class="col-sm-6">
                                    <input name="estado" type="text" class="form-control" id="inputEstado" value="<?php echo $row['estado']; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="inputPaís" class="form-label">País</label>
                                <div class="col-sm-6">
                                    <select name="pais" class="form-select" aria-label="Default select example">
                                        <option value="<?= $row['idpais']; ?>"><?= $row['pais']; ?></option>
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_pais) or die("Erro ao retornar dados");
                                        while ($c = $resultado->fetch_assoc()) : ?>
                                            <option value="<?= $c['id']; ?>"><?= $c['pais']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
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
                                <button type="submit" class="btn btn-primary">Salvar</button>
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
require "../includes/footer.php";
?>