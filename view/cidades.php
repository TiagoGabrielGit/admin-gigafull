<?php
require "../includes/menu.php";
require "../conexoes/conexao.php";
require "../conexoes/sql.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_cidade =
"SELECT
cidade.id as id,
cidade.cidade as cidade,
estado.estado as estado,
pais.pais as pais,
cidade.criado as criado,
cidade.modificado as modificado,
pais.id as idpais,
estado.id as idestado
FROM cidades as cidade
LEFT JOIN estado as estado
ON cidade.estado = estado.id
LEFT JOIN pais as pais
ON cidade.pais = pais.id
WHERE
    cidade.deleted = 1
    and
    cidade.id = '$id'
ORDER BY cidade.cidade
";

$resultado = mysqli_query($mysqli, $sql_cidade);
$row = mysqli_fetch_assoc($resultado);
?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['cidade']; ?> - <?php echo $row['estado']; ?> / <?php echo $row['pais']; ?></h5>

                        <!-- Multi Columns Form -->
                        <form method="POST" action="/processa_edit/cidades.php" class="row g-3">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="row mb-3">
                                <label for="codigo" class="col-sm-12 col-form-label">Código</label>
                                <div class="col-sm-2">
                                    <input name="codigo" type="text" class="form-control" id="codigo" value="<?php echo $row['id']; ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputCidade" class="col-sm-12 col-form-label">Cidade</label>
                                <div class="col-sm-4">
                                    <input name="cidade" type="text" class="form-control" id="inputCidade" value="<?php echo $row['cidade']; ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="inputPaís" class="form-label">País</label>
                                <select name="pais" id="inputPaís" class="form-select">
                                    <option value="<?= $row['idpais']; ?>"><?= $row['pais']; ?></option>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_pais) or die("Erro ao retornar dados");
                                    while ($c = $resultado->fetch_assoc()) : ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['pais']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="inputEstado" class="form-label">Estado</label>
                                <select name="estado" id="inputEstado" class="form-select">
                                    <option value="<?= $row['idestado']; ?>"><?= $row['estado']; ?></option>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_estados) or die("Erro ao retornar dados");
                                    while ($c = $resultado->fetch_assoc()) : ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['estado']; ?></option>
                                    <?php endwhile; ?>
                                </select>
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