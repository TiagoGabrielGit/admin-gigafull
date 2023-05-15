<?php
require "../../includes/menu.php";
require "sql.php";

$usuarioID = $_SESSION['id'];
$idPOP = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_POST['tabInformacoes'])) {
        $tab_informacoes = "show active";
        $nav_informacoes = "active";
        $tab_rack = "";
        $nav_rack = "";
        $tab_equipamentos = "";
        $nav_equipamentos = "";
        $tab_vistoria = "";
        $nav_vistoria = "";
    } else if (isset($_POST['tabRack'])) {
        $tab_informacoes = "";
        $nav_informacoes = "";
        $tab_rack = "show active";
        $nav_rack = "active";
        $tab_equipamentos = "";
        $nav_equipamentos = "";
        $tab_vistoria = "";
        $nav_vistoria = "";
    } else if (isset($_POST['tabEquipamentos'])) {
        $tab_informacoes = "";
        $nav_informacoes = "";
        $tab_rack = "";
        $nav_rack = "";
        $tab_equipamentos = "show active";
        $nav_equipamentos = "active";
        $tab_vistoria = "";
        $nav_vistoria = "";
    } else if (isset($_POST['tabVistoria'])) {
        $tab_informacoes = "";
        $nav_informacoes = "";
        $tab_rack = "";
        $nav_rack = "";
        $tab_equipamentos = "";
        $nav_equipamentos = "";
        $tab_vistoria = "show active";
        $nav_vistoria = "active";
    }
} else {
    $tab_informacoes = "show active";
    $nav_informacoes = "active";
    $tab_rack = "";
    $nav_rack = "";
    $tab_equipamentos = "";
    $nav_equipamentos = "";
    $tab_vistoria = "";
    $nav_vistoria = "";
}

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
pop.id = $idPOP        
ORDER BY
emp.fantasia asc,
city.cidade asc,
pop.pop asc
";

$resultado = mysqli_query($mysqli, $sql_pop);
$row = mysqli_fetch_assoc($resultado);

$sql_lista_rack =
    "SELECT
    rack.id as rack_id,
    pop.pop as pop,
    rack.nomenclatura as rack,
    rack.tamanho as tamanho,
    rack.polegada as polegada
    FROM
    pop_rack as rack
    LEFT JOIN
    pop as pop
    ON
    pop.id = rack.pop_id
    WHERE
    rack.pop_id LIKE '$idPOP'                   ";

$r_lista_rack = mysqli_query($mysqli, $sql_lista_rack);

$sql_lista_equipamentos =
    "SELECT
    eqp.id as idEqp,
    pr.nomenclatura as rack,
    eqp.hostname as equipamento,
    eqto.equipamento as modelo,
    eqp.statusEquipamento as status
    FROM
    equipamentospop as eqp
    LEFT JOIN
    pop_rack as pr
    ON
    pr.id = eqp.rack_id
    LEFT JOIN
    equipamentos as eqto
    ON
    eqto.id = eqp.equipamento_id
    WHERE
    eqp.deleted = 1
    and
    eqp.pop_id LIKE '$idPOP'
    ORDER BY
    pr.nomenclatura ASC,
    eqp.hostname ASC";

$r_lista_equipamentos = mysqli_query($mysqli, $sql_lista_equipamentos);
$r_lista_vistoria_equipamentos = mysqli_query($mysqli, $sql_lista_equipamentos);

$sql_usuarios =
    "SELECT
u.id as idUsuario,
p.nome as usuario
FROM
usuarios as u
LEFT JOIN
pessoas as p
ON
p.id = u.pessoa_id
WHERE
u.active = 1
ORDER BY
p.nome ASC";

$r_usuarios = mysqli_query($mysqli, $sql_usuarios);

$sql_datas_vistorias =
    "SELECT
v.id as idVistoria,
date_format(v.date, '%d/%m/%Y') as date 
FROM
vistoria as v
WHERE
v.pop_id LIKE '$idPOP'
ORDER BY
v.date DESC";
$r_datas_vistorias = mysqli_query($mysqli, $sql_datas_vistorias);
?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">POPs</h5>

                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_informacoes ?>" id="informacoes-tab" data-bs-toggle="tab" data-bs-target="#informacoes" type="button" role="tab" aria-controls="informacoes" aria-selected="true">Informacoes</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_rack ?>" id="rack-tab" data-bs-toggle="tab" data-bs-target="#rack" type="button" role="tab" aria-controls="rack" aria-selected="false" tabindex="-1">Rack</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_equipamentos ?>" id="equipamentos-tab" data-bs-toggle="tab" data-bs-target="#equipamentos" type="button" role="tab" aria-controls="equipamentos" aria-selected="false" tabindex="-1">Equipamentos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $nav_vistoria ?>" id="vistoria-tab" data-bs-toggle="tab" data-bs-target="#vistoria" type="button" role="tab" aria-controls="vistoria" aria-selected="false" tabindex="-1">Vistoria</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade <?= $tab_informacoes ?>" id="informacoes" role="tabpanel" aria-labelledby="informacoes-tab">
                                <?php require "tabs/informacoes.php" ?>
                            </div>
                            <div class="tab-pane fade <?= $tab_rack ?>" id="rack" role="tabpanel" aria-labelledby="rack-tab">
                                <?php require "tabs/rack.php" ?>
                            </div>
                            <div class="tab-pane fade <?= $tab_equipamentos ?>" id="equipamentos" role="tabpanel" aria-labelledby="equipamentos-tab">
                                <?php require "tabs/equipamentos.php" ?>
                            </div>
                            <div class="tab-pane fade <?= $tab_vistoria ?>" id="vistoria" role="tabpanel" aria-labelledby="vistoria-tab">
                                <?php require "tabs/vistoria.php" ?>
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
require "../../includes/footer.php";
?>