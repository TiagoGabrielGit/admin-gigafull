<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../includes/remove_setas_number.php";
require "sql.php";
?>

<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_pop =
    "SELECT
pop.id as id,
pop.pop as pop,
pop.apelidoPop as apelidoPop,
city.cidade as cidade,
emp.fantasia as empresa,
emp.id as id_empresa,
pais.id as id_pais,
pais.pais as nome_pais,
est.id as id_estado,
est.estado as nome_estado,
city.id as id_cidade,
city.cidade as nome_cidade,
bairro.id as id_bairro,
bairro.bairro as nome_bairro,
logradouro.id as id_logradouro,
logradouro.logradouro as nome_logradouro,
pop.numero as numero,
pop.complemento as complemento,
logradouro.cep as cep
FROM
pop as pop
LEFT JOIN
logradouros as logradouro
ON
logradouro.id = pop.logradouro_id
LEFT JOIN
cidades as city
ON
city.id = logradouro.cidade
LEFT JOIN
empresas as emp
ON
emp.id = pop.empresa_id
LEFT JOIN
estado as est
ON
est.id = city.estado
LEFT JOIN
pais as pais
ON
pais.id = est.pais
LEFT JOIN
bairros as bairro
ON
bairro.cidade = city.id
WHERE
pop.active = 1
and
pop.id = $id        
ORDER BY
emp.fantasia asc,
city.cidade asc,
pop.pop asc
";

$resultado = mysqli_query($mysqli, $sql_pop);
$row = mysqli_fetch_assoc($resultado);


?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Código <?php echo $row['id']; ?> - <?php echo $row['pop']; ?></h5>

                        <form method="POST" action="processa/edit.php" class="row g-3">

                            <li class="nav-heading" style="list-style: none;">Dados</li>


                            <input name="id" type="text" class="form-control" id="id" value="<?php echo $row['id']; ?>" hidden>


                            <div class="col-4">
                                <label for="inputEmpresa" class="form-label">Empresa</label>
                                <select id="empresa" name="empresa" class="form-select" aria-label="Default select example">
                                    <option value="<?= $row['id_empresa']; ?>"><?= $row['empresa']; ?></option>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                    while ($emp = $resultado->fetch_assoc()) : ?>
                                        <option value="<?= $emp['id']; ?>"><?= $emp['fantasia']; ?></option>
                                    <?php endwhile; ?>
                                    ?>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="pop" class="form-label">POP</label>
                                <input name="pop" type="text" class="form-control" id="pop" value="<?php echo $row['pop']; ?>" required>
                            </div>

                            <div class="col-6">
                                <label for="apelidoPop" class="form-label">Descrição</label>
                                <input name="apelidoPop" type="text" class="form-control" id="apelidoPop" value="<?php echo $row['apelidoPop']; ?>" required>
                            </div>

                            <hr class="sidebar-divider">
                            <li class="nav-heading" style="list-style: none;">Localização</li>

                            <div class="col-4">
                                <label for="cidade" class="form-label">Cidade</label>
                                <select id="cidade" name="cidade" class="form-select" aria-label="Default select example" value="<?php echo $row['nome_cidade']; ?>">
                                    <option value="<?= $row['id_cidade']; ?>"><?= $row['nome_cidade']; ?></option>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_cidade);
                                    while ($c = $resultado->fetch_assoc()) : ?>
                                        <option value="<?= $c['id']; ?>"><?= $c['cidade']; ?></option>
                                    <?php endwhile; ?>
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="inputBairro" class="form-label">Bairro</label>
                                <select id="bairro" name="bairro" class="form-select" aria-label="Default select example" value="<?php echo $row['nome_bairro']; ?>">
                                    <option value="<?= $row['id_bairro']; ?>"><?= $row['nome_bairro']; ?></option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="cep" class="form-label">CEP</label>
                                <select disabled id="cep" name="cep" class="form-select" aria-label="Default select example">
                                    <option value="<?= $row['cep']; ?>"><?= $row['cep']; ?></option>
                                </select>
                            </div>


                            <div class="col-6">
                                <label for="inputLogradouro" class="form-label">Logradouro</label>
                                <select id="logradouro" name="logradouro" class="form-select" aria-label="Default select example" value="<?php echo $row['nome_logradouro']; ?>">
                                    <option value="<?= $row['id_logradouro']; ?>"><?= $row['nome_logradouro']; ?></option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="numero" class="form-label">Número</label>
                                <input name="numero" type="number" class="form-control" id="numero" value="<?php echo $row['numero']; ?>" required>
                            </div>

                            <div class="col-4">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input name="complemento" type="text" class="form-control" id="complemento" value="<?php echo $row['complemento']; ?>">
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-4" style="text-align: left;">
                                <a href="/telecom/sitepop/rack.php?id=<?= $id ?>&pop=<?=$row['pop']?>"><input type="button" class="btn btn-info" value="Visualizar racks"></input></a>
                            </div>

                            <div class="col-4" style="text-align: center;">
                                <button name="salvar" type="submit" class="btn btn-primary">Salvar</button>
                                <input type="button" value="Voltar" onClick="history.go(-1)" class="btn btn-secondary">
                            </div>

                            <div class="col-4" style="text-align: right;">
                                <a href="processa/delete.php?id=<?= $id ?>"><input type="button" class="btn btn-danger" value="Excluir permanente"></input></a>
                            </div>

                        </form><!-- Vertical Form -->

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
require "../../scripts/pop.php";
require "../../includes/footer.php";
?>