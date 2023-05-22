<?php
require "../includes/menu.php";

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
endereco.cep as cep,
endereco.street as logradouro,
endereco.neighborhood as bairro,
endereco.city as cidade,
endereco.state as estado,
endereco.number as numero,
endereco.complement as complemento,
endereco.ibge_code as ibge_code,
date_format(empresa.criado,'%H:%m:%s %d/%m/%Y') as data_criado,
date_format(empresa.modificado,'%H:%m:%s %d/%m/%Y') as data_modificado
FROM
empresas as empresa
LEFT JOIN
company_address as endereco
ON
endereco.company_id = empresa.id
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

$fantasia = $row['fantasia'];
?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['razaoSocial']; ?> <br> <?= $row['fantasia']; ?></h5>

                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab" aria-controls="dados" aria-selected="true">Dados</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tiposProtocolos-tab" data-bs-toggle="tab" data-bs-target="#tiposProtocolos" type="button" role="tab" aria-controls="tiposProtocolos" aria-selected="false" tabindex="-1">Tipos de Protocolos</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                                <?php require "tabs/dados.php" ?>
                            </div>
                            <div class="tab-pane fade" id="tiposProtocolos" role="tabpanel" aria-labelledby="tiposProtocolos-tab">
                                <?php require "tabs/tipos_protocolos.php" ?>
                            </div>
                        </div><!-- End Default Tabs -->

                    </div>
                </div>

            </div>

        </div>
    </section>

</main>

<?php
require "js.php";
require "modalPermiteChamado.php";
require "modalDespermiteChamado.php";
require "../includes/footer.php";
?>