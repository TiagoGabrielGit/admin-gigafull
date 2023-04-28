<?php
require "../../includes/menu.php";

$usuarioID = $_SESSION['id'];
$sql_parceiro =
    "SELECT
parceiroRN_id as parceiro
FROM
usuarios as u
WHERE
u.id = $usuarioID
";

$r_sql_parceiro = mysqli_query($mysqli, $sql_parceiro);
$campo_parceiro = $r_sql_parceiro->fetch_array();

if ($campo_parceiro['parceiro'] == NULL) {
    $parceidoID = "%";
} else {
    $parceidoID = $campo_parceiro['parceiro'];
}

$idProvisionamento = $_GET['idProvisionamento'];
$sql_provisionamento =
    "SELECT
count(rnop.id) as contagem,
rnop.id as idProvisionamento,
p.nome as usuario_ativador,
rnop.descricao as descricaoONU,
rnop.slot_olt as slotOLT,
rnop.pon_olt as ponOLT,
rnop.id_onu as idONU,
rnop.serial_onu as serialONU,
date_format(rnop.data_provisionamento,'%H:%i:%s %d/%m/%Y') as data_provisionamento,
e.fantasia as fantasia,
rno.olt_name as nameOLT,
rnop.olt_id as idOLT
FROM
redeneutra_onu_provisionadas as rnop
LEFT JOIN
redeneutra_parceiro as rnp
ON
rnp.id = rnop.parceiro_id
LEFT JOIN
empresas as e
ON
e.id = rnp.empresa_id
LEFT JOIN
redeneutra_olts as rno
ON
rno.id = rnop.olt_id
LEFT JOIN
usuarios as u
ON
u.id = rnop.criado_por
LEFT JOIN
pessoas as p
ON
p.id = u.pessoa_id
WHERE
rnop.id = $idProvisionamento
and
rnop.parceiro_id LIKE ('$parceidoID')
";

$r_provisionamento = mysqli_query($mysqli, $sql_provisionamento);
$campos = $r_provisionamento->fetch_array();

if ($campos['contagem'] == 1) { ?>

    <style>
        .border-desconexao {

            border: 1px solid #737272 !important;
            margin-top: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 5px;
        }

        .border-conexao {

            border: 1px solid #737272 !important;
            margin-top: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 5px;
        }

        .border-infos-olt {
            border: 2px solid black !important;
            margin-top: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            padding-top: 5px;
            padding-right: 20px;
            padding-bottom: 10px;
            padding-left: 20px;
        }

        .border-infos-sistema {
            border: 2px solid black !important;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-right: 1px;
            margin-left: 1px;
            border-radius: 5px;
            padding-top: 5px;
            padding-right: 10px;
            padding-bottom: 10px;
            padding-left: 10px;
        }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Provisionamento</h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="informacoes-tab" data-bs-toggle="tab" data-bs-target="#informacoes" type="button" role="tab" aria-controls="informacoes" aria-selected="true">Informações</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab" aria-controls="services" aria-selected="false">Serviços (Beta)</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="diagnostico-tab" data-bs-toggle="tab" data-bs-target="#diagnostico" type="button" role="tab" aria-controls="diagnostico" aria-selected="false">Diagnóstico</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="acoes-tab" data-bs-toggle="tab" data-bs-target="#acoes" type="button" role="tab" aria-controls="portal" aria-selected="false">Ações</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="false">LOG</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content pt-2" id="myTabContent">
                                            <div class="tab-pane fade show active" id="informacoes" role="tabpanel" aria-labelledby="informacoes-tab">
                                                <?php
                                                require "tabs/informacoes.php";
                                                ?>
                                            </div>
                                            <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                                                <?php
                                                require "tabs/services.php";
                                                ?>
                                            </div>
                                            <div class="tab-pane fade" id="diagnostico" role="tabpanel" aria-labelledby="diagnostico-tab">
                                                <?php
                                                require "tabs/diagnostico.php";
                                                ?>
                                            </div>
                                            <div class="tab-pane fade" id="acoes" role="tabpanel" aria-labelledby="acoes-tab">
                                                <?php
                                                require "tabs/acoes.php";
                                                ?>
                                            </div>
                                            <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                                                <?php
                                                require "tabs/log.php";
                                                ?>
                                            </div>
                                        </div><!-- End Default Tabs -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php } else { ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Operação não permitida!</h1>
        </div>
    </main>
<?php } ?>

<?php
require "jscript.php";
require "../../includes/footer.php";
?>