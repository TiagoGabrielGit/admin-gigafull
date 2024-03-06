<?php
require "../includes/menu.php";
require "../conexoes/conexao_pdo.php";
$uid = $_SESSION['id'];
$page_type = "menu";
$menu_submenu_id = "2";


if ($page_type == "submenu") {
    $permissions =
        "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $menu_submenu_id";
} else if ($page_type == "menu") {
    $permissions =
        "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_menu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_menu = $menu_submenu_id";
}
$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {


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
                                    <button class="nav-link" id="notificacao-tab" data-bs-toggle="tab" data-bs-target="#notificacao" type="button" role="tab" aria-controls="notificacao" aria-selected="false" tabindex="-1">Notificação</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="myTabContent">
                                <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                                    <?php require "tabs/dados.php" ?>
                                </div>
                                <div class="tab-pane fade" id="notificacao" role="tabpanel" aria-labelledby="notificacao-tab">
                                    <?php require "tabs/notificacao.php" ?>
                                </div>
                            </div><!-- End Default Tabs -->

                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>

<?php
    require 'js.php';
} else {
    require "../acesso_negado.php";
}
require "../includes/securityfooter.php";
?>