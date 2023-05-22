<?php
require "../includes/menu.php";
require "../conexoes/conexao.php";
require "../conexoes/sql.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_lograd =
    "SELECT
    logradouro.id as id_logradouro,
	logradouro.logradouro as nome_logradouro,
    logradouro.criado as data_criado,
    logradouro.modificado as data_modificado,
    logradouro.deleted as logradouro_deletado,
	logradouro.cep as cep,
    cidade.id as id_cidade,
	cidade.cidade as nome_cidade,
    estado.id as id_estado,
	estado.estado as nome_estado,
    pais.id as id_pais,
	pais.pais as nome_pais,
	bairro.id as id_bairro,
    bairro.bairro as nome_bairro
FROM 
    logradouros as logradouro
LEFT JOIN
    cidades as cidade
    ON
    cidade.id = logradouro.cidade
LEFT JOIN
    bairros as bairro
    ON
    bairro.id = logradouro.bairro 
LEFT JOIN
    pais as pais
    ON
    pais.id = logradouro.pais      
LEFT JOIN
    estado as estado
    ON
    estado.id = logradouro.estado   
WHERE
    logradouro.deleted = 1
    and
    logradouro.id = $id
ORDER BY 
    pais.pais ASC,
    estado.estado ASC,
    cidade.cidade ASC,
    logradouro.logradouro ASC
";

$resultado = mysqli_query($mysqli, $sql_lograd);
$row = mysqli_fetch_assoc($resultado);
?>


<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['nome_cidade']; ?> - <?php echo $row['nome_bairro']; ?> - <?php echo $row['nome_logradouro']; ?></h5>

                        <!-- Multi Columns Form -->
                        <form method="POST" action="/processa_edit/logradouros.php" class="row g-3">
                            <input type="hidden" name="id" value="<?php echo $row['id_logradouro']; ?>">

                            <div class="row mb-3">
                                <label for="codigo" class="col-sm-12 col-form-label">Código</label>
                                <div class="col-sm-2">
                                    <input name="codigo" type="text" class="form-control" id="codigo" value="<?php echo $row['id_logradouro']; ?>" disabled>
                                </div>
                            </div>

                            <div class="col mb-4">
                                <label for="inputLogradouro" class="col-sm-12 col-form-label">Logradouro</label>
                                <div class="col-sm-12">
                                    <input name="logradouro" type="text" class="form-control" id="inputLogradouro" value="<?php echo $row['nome_logradouro']; ?>">
                                </div>
                            </div>

                            <div class="col mb-4">
                                <label for="inputCEP" class="col-sm-12 col-form-label">CEP</label>
                                <div class="col-sm-12">
                                    <input name="cep" type="text" class="form-control" id="inputCEP" value="<?php echo $row['cep']; ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="inputPais" class="form-label">País</label>
                                <div class="col-sm-12">
                                    <select id="pais" name="pais" class="form-select" aria-label="Default select example">
                                        <option value="<?= $row['id_pais']; ?>"><?= $row['nome_pais']; ?></option>
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_pais) or die("Erro ao retornar dados");
                                        while ($p = $resultado->fetch_assoc()) : ?>
                                            <option value="<?= $p['id']; ?>"><?= $p['pais']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                            </div>

                            <div class="col-md-4">
                                <label for="inputEstado" class="form-label">Estado</label>
                                <select id="estado" name="estado" class="form-select" aria-label="Default select example">
                                    <option value="<?= $row['id_estado']; ?>"><?= $row['nome_estado']; ?></option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="inputCidade" class="form-label">Cidade</label>
                                <select id="cidade" name="cidade" class="form-select" aria-label="Default select example">
                                <option value="<?= $row['id_cidade']; ?>"><?= $row['nome_cidade']; ?></option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="inputBairro" class="form-label">Bairro</label>
                                <select id="bairro" name="bairro" class="form-select" aria-label="Default select example">
                                <option value="<?= $row['id_bairro']; ?>"><?= $row['nome_bairro']; ?></option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="dateCreated" class="form-label">Data criação</label>
                                <div class="col-sm-6">
                                    <input name="dateCreated" type="text" class="form-control" id="dateCreated" value="<?php echo $row['data_criado']; ?>" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="dateModified" class="form-label">última modificação</label>
                                <div class="col-sm-6">
                                    <input name="dateModified" type="text" class="form-control" id="dateModified" value="<?php echo $row['data_modificado']; ?>" disabled>
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



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    //Pesquisa os estados passando ID do país
    $("#pais").change(function() {
        var paisselecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "../api/pesquisa_estado.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: paisselecionado
            }
        }).done(function(resposta) {
            $("#estado").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa as cidades passando ID do estado
    $("#estado").change(function() {
        var estadoSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "../api/pesquisa_cidade.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: estadoSelecionado
            }
        }).done(function(resposta) {
            $("#cidade").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa os bairros passando ID da cidade
    $("#cidade").change(function() {
        var cidadeSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "../api/pesquisa_bairro.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: cidadeSelecionado
            }
        }).done(function(resposta) {
            $("#bairro").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<?php
require "../includes/footer.php";
?>