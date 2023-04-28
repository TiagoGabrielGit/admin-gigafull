<?php
require "../includes/menu.php";
require "../conexoes/conexao.php";
require "../conexoes/sql.php";
require "../includes/remove_setas_number.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql =
    "SELECT
empresa.id as id_empresa,
empresa.razaoSocial as razaoSocial,
empresa.fantasia as fantasia,
empresa.cnpj as cnpj,
empresa.email as email,
empresa.telefone as telefone,
empresa.celular as celular,
empresa.atributoCliente as atributoCliente,
empresa.atributoEmpresaPropria as atributoEmpresaPropria,
empresa.atributoFornecedor as atributoFornecedor,
empresa.atributoTransportadora as atributoTransportadora,
empresa.atributoPrestadorServico as atributoPrestadorServico,
date_format(empresa.criado,'%H:%m:%s %d/%m/%Y') as data_criado,
date_format(empresa.modificado,'%H:%m:%s %d/%m/%Y') as data_modificado
FROM
empresas as empresa
WHERE
empresa.id = $id
";

$resultado = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($resultado);

if (isset($row['atributoCliente']) and ($row['atributoCliente'] == 1)) {
    $atributoClienteChecked = "checked";
} else {
    $atributoClienteChecked = "";
}

if (isset($row['atributoFornecedor']) and ($row['atributoFornecedor'] == 1)) {
    $atributoFornecedorChecked = "checked";
} else {
    $atributoFornecedorChecked = "";
}

if (isset($row['atributoTransportadora']) and ($row['atributoTransportadora'] == 1)) {
    $atributoTransportadoraChecked = "checked";
} else {
    $atributoTransportadoraChecked = "";
}

if (isset($row['atributoPrestadorServico']) and ($row['atributoPrestadorServico'] == 1)) {
    $atributoPrestadorServicoChecked = "checked";
} else {
    $atributoPrestadorServicoChecked = "";
}

if (isset($row['atributoEmpresaPropria']) and ($row['atributoEmpresaPropria'] == 1)) {
    $atributoEmpresaPropriaChecked = "checked";
} else {
    $atributoEmpresaPropriaChecked = "";
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
empresas_endereco as endereco
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
endereco.empresa_id = $id
";

$resultado_endereco_atual = mysqli_query($mysqli, $sql_endereco_atual);
$row_endereco_atual = mysqli_fetch_assoc($resultado_endereco_atual);
?>


<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['razaoSocial']; ?> <br> <?php echo $row['fantasia']; ?></h5>

                        <!-- Multi Columns Form -->
                        <form method="POST" action="processa/edit.php" class="row g-3">
                            <input type="hidden" name="id" value="<?php echo $row['id_empresa']; ?>">

                            <hr class="sidebar-divider">

                            <div class="row mb-3">
                                <label for="codigo" class="col-sm-12 col-form-label">Código</label>
                                <div class="col-sm-2">
                                    <input name="codigo" type="text" class="form-control" id="codigo" value="<?php echo $row['id_empresa']; ?>" disabled>
                                </div>
                            </div>

                            <div class="col mb-6">
                                <label for="razaoSocial" class="col-sm-12 col-form-label">Razão Social</label>
                                <div class="col-sm-12">
                                    <input name="razaoSocial" type="text" class="form-control" id="razaoSocial" value="<?php echo $row['razaoSocial']; ?>">
                                </div>
                            </div>

                            <div class="col mb-6">
                                <label for="fantasia" class="col-sm-12 col-form-label">Fantasia</label>
                                <div class="col-sm-12">
                                    <input name="fantasia" type="text" class="form-control" id="fantasia" value="<?php echo $row['fantasia']; ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                            </div>

                            <div class="col mb-3">
                                <label for="cnpj" class="col-sm-12 col-form-label">CNPJ</label>
                                <div class="col-sm-12">
                                    <input required name="cnpj" type="text" class="form-control" id="cnpj" minlength="14" maxlength="14" value="<?php echo $row['cnpj']; ?>">
                                </div>
                            </div>

                            <div class="col-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input name="email" type="email" class="form-control" id="email" value="<?php echo $row['email']; ?>" required>
                            </div>

                            <div class="col-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input name="telefone" type="text" class="form-control" id="telefone" value="<?php echo $row['telefone']; ?>" required>
                            </div>

                            <div class="col-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input name="celular" type="text" class="form-control" id="celular" value="<?php echo $row['celular']; ?>" required>
                            </div>

                            <hr class="sidebar-divider">
                            <li class="nav-heading" style="list-style: none;">Atributos</li>

                            <div class="col-6">
                                <ul class="list-group" style="list-style: none;">
                                    <li> <input class="form-check-input me-1" name="atributoCliente" type="checkbox" value="1" <?php echo $atributoClienteChecked; ?>>Cliente</li>
                                    <li> <input class="form-check-input me-1" name="atributoEmpresaPropria" type="checkbox" value="1" <?php echo $atributoEmpresaPropriaChecked; ?>> Empresa Própria</li>
                                    <li> <input class="form-check-input me-1" name="atributoFornecedor" type="checkbox" value="1" <?php echo $atributoFornecedorChecked; ?>> Fornecedor</li>
                                </ul>
                            </div>

                            <div class="col-6">
                                <ul class="list-group" style="list-style: none;">
                                    <li> <input class="form-check-input me-1" name="atributoPrestadorServico" type="checkbox" value="1" <?php echo $atributoPrestadorServicoChecked; ?>> Prestador de Serviço</li>
                                    <li> <input class="form-check-input me-1" name="atributoTransportadora" type="checkbox" value="1" <?php echo $atributoTransportadoraChecked; ?>> Transportadora</li>
                                </ul>
                            </div>

                            <hr class="sidebar-divider">


                            <div class="col-4">
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

                            <div class="col-6">
                                <label for="inputLogradouro" class="form-label">Logradouro</label>
                                <select id="logradouro" name="logradouro" class="form-select" aria-label="Default select example" value="<?php echo $row_endereco_atual['nome_logradouro']; ?>">
                                    <option value="<?= $row_endereco_atual['id_logradouro']; ?>"><?= $row_endereco_atual['nome_logradouro']; ?></option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="cep" class="form-label">CEP</label>
                                <select disabled id="cep" name="cep" class="form-select" aria-label="Default select example">
                                    <option value="<?= $row_endereco_atual['cep']; ?>"><?= $row_endereco_atual['cep']; ?></option>
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
require "../scripts/empresas.php";
require "../includes/footer.php";
?>