<?php
require "../includes/menu.php";
require "../conexoes/conexao.php";
require "../conexoes/sql.php";
require '../includes/remove_setas_number.php';
?>


<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_pessoas =
    "SELECT
pessoa.id as id,
pessoa.nome as nome,
pessoa.email as email,
pessoa.cpf as cpf,
pessoa.telefone as telefone,
pessoa.celular as celular,
atributoCliente as atributoCliente,
permiteUsuario as permiteUsuario,
atributoPrestadorServico as atributoPrestadorServico

FROM
    pessoas as pessoa
WHERE
pessoa.id = $id
";

$resultado = mysqli_query($mysqli, $sql_pessoas);
$row = mysqli_fetch_assoc($resultado);



if (isset($row['atributoCliente']) and ($row['atributoCliente'] == 1)) {
    $atributoClienteChecked = "checked";
} else {
    $atributoClienteChecked = "";
}

if (isset($row['permiteUsuario']) and ($row['permiteUsuario'] == 1)) {
    $permiteUsuarioChecked = "checked";
} else {
    $permiteUsuarioChecked = "";
}

if (isset($row['atributoPrestadorServico']) and ($row['atributoPrestadorServico'] == 1)) {
    $atributoPrestadorServicoChecked = "checked";
} else {
    $atributoPrestadorServicoChecked = "";
}



$sql_endereco_atual =
    "SELECT 
pais.id as id_pais,
pais.pais as nome_pais,
estado.id as id_estado,
estado.estado as nome_estado,
cidade.id as id_cidade,
cidade.cidade as nome_cidade,
bairro.id as id_bairro,
bairro.bairro as nome_bairro,
logradouro.id as id_logradouro,
logradouro.logradouro as nome_logradouro,
logradouro.cep as cep,
endereco.numero as numero,
endereco.complemento as complemento
FROM
pessoas_endereco as endereco
LEFT JOIN
logradouros as logradouro
ON
logradouro.id = endereco.logradouro_id
LEFT JOIN
bairros as bairro
ON
bairro.id = logradouro.bairro
LEFT JOIN
cidades as cidade
ON    
cidade.id = bairro.cidade
LEFT JOIN
estado as estado
ON    
estado.id = cidade.estado
LEFT JOIN
pais as pais
ON    
pais.id = estado.pais
WHERE
endereco.pessoa_id = $id
";

$resultado_endereco = mysqli_query($mysqli, $sql_endereco_atual);

$row_endereco_atual = mysqli_fetch_array($resultado_endereco);

?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Código <?php echo $row['id']; ?> - <?php echo $row['nome']; ?></h5>

                        <form method="POST" action="/pessoas/processa/edit.php" class="row g-3">

                            <li class="nav-heading" style="list-style: none;">Dados</li>


                            <input name="id" type="text" class="form-control" id="id" value="<?php echo $row['id']; ?>" hidden>


                            <div class="col-8">
                                <label for="nomePessoa" class="form-label">Nome</label>
                                <input name="nomePessoa" type="text" class="form-control" id="nomePessoa" value="<?php echo $row['nome']; ?>" required>
                            </div>

                            <div class="col-4">
                                <label for="cpf" class="form-label">CPF</label>
                                <input name="cpf" type="text" class="form-control" id="cpf" minlength="11" maxlength="11" value="<?php echo $row['cpf']; ?>" required>
                            </div>

                            <div class="col-4">
                                <label for="email" class="form-label">E-mail</label>
                                <input name="email" type="text" class="form-control" id="email" value="<?php echo $row['email']; ?>" required>
                            </div>

                            <div class="col-4">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input name="telefone" type="text" class="form-control" id="telefone" minlength="13" maxlength="13" value="<?php echo $row['telefone']; ?>">
                            </div>

                            <div class="col-4">
                                <label for="celular" class="form-label">Celular</label>
                                <input name="celular" type="text" class="form-control" id="celular" minlength="14" maxlength="14" value="<?php echo $row['celular']; ?>" required>
                            </div>

                            <hr class="sidebar-divider">
                            <li class="nav-heading" style="list-style: none;">Atributos</li>

                            <div class="col-6">
                                <ul class="list-group" style="list-style: none;">
                                    <li> <input class="form-check-input me-1" name="atributoCliente" type="checkbox" value="1" <?php echo $atributoClienteChecked; ?>> Cliente</li>
                                    <li> <input class="form-check-input me-1" name="permiteUsuario" type="checkbox" value="1" <?php echo $permiteUsuarioChecked; ?>> Permite Usuário</li>
                                    <li> <input class="form-check-input me-1" name="atributoPrestadorServico" type="checkbox" value="1" <?php echo $atributoPrestadorServicoChecked; ?>> Prestador de Serviço</li>
                                </ul>
                            </div>

                            <hr class="sidebar-divider">
                            <li class="nav-heading" style="list-style: none;">Localização</li>

                            <div class="col-6">
                                <label for="inputPaís" class="form-label">País</label>
                                <select id="pais" name="pais" class="form-select" aria-label="Default select example">
                                    <option value="<?= $row_endereco_atual['id_pais']; ?>"><?= $row_endereco_atual['nome_pais']; ?></option>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_pais);
                                    while ($p = $resultado->fetch_assoc()) : ?>
                                        <option value="<?= $p['id']; ?>"><?= $p['pais']; ?></option>
                                    <?php endwhile; ?>
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="inputEstado" class="form-label">Estado</label>
                                <select id="estado" name="estado" class="form-select" aria-label="Default select example">
                                    <option value="<?= $row_endereco_atual['id_estado']; ?>"><?= $row_endereco_atual['nome_estado']; ?></option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="inputCidade" class="form-label">Cidade</label>
                                <select id="cidade" name="cidade" class="form-select" aria-label="Default select example" value="<?php echo $row_endereco_atual['nome_cidade']; ?>">
                                    <option value="<?= $row_endereco_atual['id_cidade']; ?>"><?= $row_endereco_atual['nome_cidade']; ?></option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="inputBairro" class="form-label">Bairro</label>
                                <select id="bairro" name="bairro" class="form-select" aria-label="Default select example" value="<?php echo $row_endereco_atual['nome_bairro']; ?>">
                                    <option value="<?= $row_endereco_atual['id_bairro']; ?>"><?= $row_endereco_atual['nome_bairro']; ?></option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="cep" class="form-label">CEP</label>
                                <select disabled id="cep" name="cep" class="form-select" aria-label="Default select example">
                                    <option value="<?= $row_endereco_atual['cep']; ?>"><?= $row_endereco_atual['cep']; ?></option>
                                </select>
                            </div>


                            <div class="col-6">
                                <label for="inputLogradouro" class="form-label">Logradouro</label>
                                <select id="logradouro" name="logradouro" class="form-select" aria-label="Default select example" value="<?php echo $row_endereco_atual['nome_logradouro']; ?>">
                                    <option value="<?= $row_endereco_atual['id_logradouro']; ?>"><?= $row_endereco_atual['nome_logradouro']; ?></option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="numero" class="form-label">Número</label>
                                <input name="numero" type="number" class="form-control" id="numero" value="<?php echo $row_endereco_atual['numero']; ?>" required>
                            </div>

                            <div class="col-4">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input name="complemento" type="text" class="form-control" id="complemento" value="<?php echo $row_endereco_atual['complemento']; ?>">
                            </div>

                            <hr class="sidebar-divider">

                            <div class="text-center">
                                <button name="salvar" type="submit" class="btn btn-danger">Salvar</button>
                                <input type="button" value="Voltar" onClick="history.go(-1)" class="btn btn-secondary">
                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
require "../scripts/pessoas.php";
require "../includes/footer.php";
?>