<?php
require "../includes/menu.php";
require "../conexoes/conexao.php";
require "../conexoes/sql.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_bairros =
"SELECT
bairro.id as id,
bairro.bairro as bairro,
bairro.criado as criado,
bairro.modificado as modificado,
cidade.cidade as cidade,
cidade.id as idcidade
FROM bairros as bairro
LEFT JOIN cidades as cidade
ON cidade.id = bairro.cidade
WHERE 
    bairro.deleted = 1
    and
    bairro.id = $id
ORDER BY 
cidade.cidade ASC,
bairro.bairro ASC
";

$resultado = mysqli_query($mysqli, $sql_bairros);
$row = mysqli_fetch_assoc($resultado);
?>


<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['cidade']; ?> - <?php echo $row['bairro']; ?></h5>

                        <!-- Multi Columns Form -->
                        <form method="POST" action="/processa_edit/bairros.php" class="row g-3">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="row mb-3">
                                <label for="codigo" class="col-sm-12 col-form-label">Código</label>
                                <div class="col-sm-2">
                                    <input name="codigo" type="text" class="form-control" id="codigo" value="<?php echo $row['id']; ?>" disabled>
                                </div>
                            </div>

                            <div class="col mb-4">
                                <label for="inputBairro" class="col-sm-12 col-form-label">Bairro</label>
                                <div class="col-sm-6">
                                    <input name="bairro" type="text" class="form-control" id="inputBairro" value="<?php echo $row['bairro']; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="inputCidade" class="form-label">Cidade</label>
                                <div class="col-sm-6">
                                    <select name="cidade" class="form-select" aria-label="Default select example">
                                        <option value="<?= $row['idcidade']; ?>"><?= $row['cidade']; ?></option>
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_cidade) or die("Erro ao retornar dados");
                                        while ($c = $resultado->fetch_assoc()) : ?>
                                            <option value="<?= $c['id']; ?>"><?= $c['cidade']; ?></option>
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