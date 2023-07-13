<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
require "sql.php";

$usuarioID = $_SESSION['id'];
$idPOP = $_GET['id'];

$sql_pop =
    "SELECT
    pop.id as id,
    pop.pop as pop,
    pop.apelidoPop as apelidoPop,
    endereco.city as cidade,
    emp.fantasia as empresa,
    emp.id as id_empresa,
    endereco.cep as cep,
    endereco.street as logradouro,
    endereco.neighborhood as bairro,
    endereco.city as cidade,
    endereco.state as estado,
    endereco.number as numero,
    endereco.complement as complemento,
    endereco.ibge_code as ibge_code
    FROM
    pop as pop
    LEFT JOIN
    pop_address as endereco
    ON
    endereco.pop_id = pop.id
    LEFT JOIN
    empresas as emp
    ON
    emp.id = pop.empresa_id
    WHERE
    pop.active = 1
    and
    pop.id = $idPOP    
    ORDER BY
    emp.fantasia asc,
    endereco.city asc,
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
$r2_lista_vistoria_equipamentos = mysqli_query($mysqli, $sql_lista_equipamentos);

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

if (isset($_GET['tab'])) {
    $_SESSION['active_tab'] = $_GET['tab'];
}

$active_tab = isset($_SESSION['active_tab']) ? $_SESSION['active_tab'] : 'informacoes';



?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">POP <?= $row['pop']; ?></h5>

                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $active_tab === 'informacoes' ? 'active' : ''; ?>" id="informacoes-tab" data-bs-toggle="tab" data-bs-target="#informacoes" type="button" role="tab" aria-controls="informacoes" aria-selected="true" onclick="window.location.href = 'view.php?id=<?= $idPOP ?>&tab=informacoes';">Informacoes</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $active_tab === 'rack' ? 'active' : ''; ?>" id="rack-tab" data-bs-toggle="tab" data-bs-target="#rack" type="button" role="tab" aria-controls="rack" aria-selected="false" onclick="window.location.href = 'view.php?id=<?= $idPOP ?>&tab=rack';">Rack</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $active_tab === 'equipamentos' ? 'active' : ''; ?>" id="equipamentos-tab" data-bs-toggle="tab" data-bs-target="#equipamentos" type="button" role="tab" aria-controls="equipamentos" aria-selected="false" onclick="window.location.href = 'view.php?id=<?= $idPOP ?>&tab=equipamentos';">Equipamentos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $active_tab === 'energia' ? 'active' : ''; ?>" id="energia-tab" data-bs-toggle="tab" data-bs-target="#energia" type="button" role="tab" aria-controls="energia" aria-selected="false" onclick="window.location.href = 'view.php?id=<?= $idPOP ?>&tab=energia';">Energia</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $active_tab === 'arCondicionado' ? 'active' : ''; ?>" id="arCondicionado-tab" data-bs-toggle="tab" data-bs-target="#arCondicionado" type="button" role="tab" aria-controls="arCondicionado" aria-selected="false" onclick="window.location.href = 'view.php?id=<?= $idPOP ?>&tab=arCondicionado';">Ar Condicionado</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $active_tab === 'materiais' ? 'active' : ''; ?>" id="materiais-tab" data-bs-toggle="tab" data-bs-target="#materiais" type="button" role="tab" aria-controls="materiais" aria-selected="false" onclick="window.location.href = 'view.php?id=<?= $idPOP ?>&tab=materiais';">Materiais</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $active_tab === 'anexo' ? 'active' : ''; ?>" id="anexo-tab" data-bs-toggle="tab" data-bs-target="#anexo" type="button" role="tab" aria-controls="anexo" aria-selected="false" onclick="window.location.href = 'view.php?id=<?= $idPOP ?>&tab=anexo';">Anexos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $active_tab === 'atividades' ? 'active' : ''; ?>" id="atividades-tab" data-bs-toggle="tab" data-bs-target="#atividades" type="button" role="tab" aria-controls="atividades" aria-selected="false" onclick="window.location.href = 'view.php?id=<?= $idPOP ?>&tab=atividades';">Atividades</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $active_tab === 'vistoria' ? 'active' : ''; ?>" id="vistoria-tab" data-bs-toggle="tab" data-bs-target="#vistoria" type="button" role="tab" aria-controls="vistoria" aria-selected="false" onclick="window.location.href = 'view.php?id=<?= $idPOP ?>&tab=vistoria';">Vistoria</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">

                            <div class="tab-pane fade <?= $active_tab === 'informacoes' ? 'show active' : ''; ?>" id="informacoes" role="tabpanel" aria-labelledby="informacoes-tab">
                                <?php require "tabs/informacoes.php" ?>
                            </div>


                            <div class="tab-pane fade <?= $active_tab === 'rack' ? 'show active' : ''; ?>" id="rack" role="tabpanel" aria-labelledby="rack-tab">
                                <?php require "tabs/rack.php" ?>
                            </div>


                            <div class="tab-pane fade <?= $active_tab === 'equipamentos' ? 'show active' : ''; ?>" id="equipamentos" role="tabpanel" aria-labelledby="equipamentos-tab">
                                <?php require "tabs/equipamentos.php" ?>
                            </div>

                            <div class="tab-pane fade <?= $active_tab === 'energia' ? 'show active' : ''; ?>" id="energia" role="tabpanel" aria-labelledby="energia-tab">
                                <?php require "tabs/energia.php" ?>
                            </div>


                            <div class="tab-pane fade <?= $active_tab === 'arCondicionado' ? 'show active' : ''; ?>" id="arCondicionado" role="tabpanel" aria-labelledby="arCondicionado-tab">
                                <?php require "tabs/arCondicionado.php" ?>
                            </div>

                            <div class="tab-pane fade <?= $active_tab === 'materiais' ? 'show active' : ''; ?>" id="materiais" role="materiais" aria-labelledby="materiais-tab">
                                <?php require "tabs/materiais.php" ?>
                            </div>

                            <div class="tab-pane fade <?= $active_tab === 'anexo' ? 'show active' : ''; ?>" id="anexo" role="tabpanel" aria-labelledby="anexo-tab">
                                <?php require "tabs/anexo.php" ?>
                            </div>

                            <div class="tab-pane fade  <?= $active_tab === 'atividades' ? 'show active' : ''; ?>" id="atividades" role="tabpanel" aria-labelledby="atividades-tab">
                                <?php require "tabs/atividades.php" ?>
                            </div>

                            <div class="tab-pane fade  <?= $active_tab === 'vistoria' ? 'show active' : ''; ?>" id="vistoria" role="tabpanel" aria-labelledby="vistoria-tab">
                                <?php require "tabs/vistoria.php" ?>
                            </div>
                        </div>
                    </div><!-- End Default Tabs -->
                </div>
            </div>
        </div>
    </section>
</main>
<?php
require "js.php";
require "../../includes/footer.php";
?>