<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";

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

$id_incidente = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_incidente =
    "SELECT
count(rni.id) as contagem,
rni.id as idIncidente,
rni.zabbix_event_id as zabbixID,
eqpop.hostname as equipamento,
rni.descricaoIncidente as descricaoIncidente,
CASE
WHEN rni.active = 1 THEN 'Incidente aberto'
WHEN rni.active = 0 THEN 'Normalizado'
END active,
rni.active as activeID,
date_format(rni.inicioIncidente,'%H:%i:%s %d/%m/%Y') as horainicial,
date_format(rni.fimIncidente,'%H:%i:%s %d/%m/%Y') as horafinal,
IF (rni.fimIncidente IS NULL, TIMEDIFF(NOW(), rni.inicioIncidente), TIMEDIFF(rni.fimIncidente, rni.inicioIncidente)) as tempoIncidente
FROM
redeneutra_incidentes as rni
LEFT JOIN
equipamentospop as eqpop
ON
eqpop.id = rni.equipamento_id
LEFT JOIN
redeneutra_olts as rno
ON
rno.equipamento_id = rni.equipamento_id
LEFT JOIN
redeneutra_parceiro_olt as rnpo
ON
rnpo.olt_id = rno.id
WHERE
rnpo.active = 1
and
rni.id = $id_incidente
and
rnpo.parceiro_id LIKE ('$parceidoID')
";

$r_sql_incidente = mysqli_query($mysqli, $sql_incidente);
$campos = mysqli_fetch_assoc($r_sql_incidente);

if ($campos['contagem'] >= 1) { ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Incidente #<?= $campos['idIncidente'] ?></h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <b>Equipamento: </b><?= $campos['equipamento'] ?><br>
                                    <b>Autor: </b> <?php if ($campos['zabbixID'] <> null) {
                                                        echo "Integração Zabbix";
                                                    } ?><br>
                                </div>
                                <div class="col-5">
                                    <b>Hora Inicial: </b><?= $campos['horainicial']; ?><br>
                                    <b>Hora Normalização: </b><?= $campos['horafinal']; ?><br><br>
                                    <b>Tempo total incidente: </b><?= $campos['tempoIncidente']; ?>
                                </div>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="accordion" id="accordionFlushExample">
                                <?php
                                $sql_relatos_incidentes =
                                    "SELECT
                                    rnir.id as id_relato,
                                    rnir.relato as relato,
                                    rni.zabbix_event_id as zabbixID,
                                    date_format(rnir.horarioRelato,'%H:%i:%s %d/%m/%Y') as horarioRelato
                                FROM
                                    redeneutra_incidentes_relatos as rnir
                                LEFT JOIN
                                    redeneutra_incidentes as rni
                                ON
                                    rni.id = rnir.incidente_id
                                WHERE
                                    rnir.incidente_id = $id_incidente
                                ORDER BY
                                    rnir.horarioRelato DESC
                                ";

                                $resultado_relatos = mysqli_query($mysqli, $sql_relatos_incidentes)  or die("Erro ao retornar dados");
                                $cont = 1;
                                while ($campos = $resultado_relatos->fetch_array()) {
                                    $id_relato = $campos['id_relato'];

                                ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-heading<?= $cont ?>"> <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">Relato #<?= $id_relato ?></button></h2>
                                        <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <b>Horário Relato: </b> <?= $campos['horarioRelato'] ?><br>
                                                <b>Autor: </b> <?php if ($campos['zabbixID'] <> null) {
                                                                    echo "Integração Zabbix";
                                                                } ?> <br>
                                                <hr class="sidebar-divider">
                                                <b>Descrição: </b> <br><?= nl2br($campos['relato']); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php $cont++;
                                } ?>
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
<?php
}
require "../../includes/footer.php";
?>