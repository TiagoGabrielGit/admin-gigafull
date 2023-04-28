<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
?>

<?php
//CAPTURA VIA GET O NOME DO EVENTO
$idEvent = $_GET["idEvent"];

//PESQUISA O EVENTO SELECIONADO
$evento_selecionado =
    "SHOW EVENTS LIKE '$idEvent'";
$r_evento_selecionado = mysqli_query($mysqli, $evento_selecionado);
$campos_evento_selecionado = mysqli_fetch_assoc($r_evento_selecionado);

$event_schedule =
    "SELECT
es.id as id_event,
es.event_name as event_name,
es.chamado_assunto as chamado_assunto,
es.event_desc as event_desc,
es.chamado_relato as chamado_relato,
tc.tipo as tipo_chamado,
e.fantasia as fantasia
FROM
event_scheduler as es
LEFT JOIN
empresas as e
ON
e.id = es.empresa_id
LEFT JOIN
tipos_chamados as tc
ON
tc.id = es.tipo_chamado_id
WHERE
es.id = $idEvent";

$r_event_schedule = mysqli_query($mysqli, $event_schedule);
$campos_event_Scheduler = $r_event_schedule->fetch_array();
?>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <hr class="sidebar-divider">

                        <div class="row g-3">
                            <span>Informações do evento</span>

                            <div class="col-lg-6">
                                <div class="row g-3">
                                    <div class="col-2">
                                        <label class="form-label">Evento</label>
                                        <input type="text" class="form-control" value="<?= $campos_evento_selecionado['Name'] ?>" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-3">
                                        <label class="form-label">Tipo</label>
                                        <input type="text" class="form-control" value="<?= $campos_evento_selecionado['Type'] ?>" disabled>
                                    </div>

                                    <div class="col-3">
                                        <label class="form-label">Intervalo</label>
                                        <input type="text" class="form-control" value="<?= $campos_evento_selecionado['Interval value'] ?>" disabled>
                                    </div>

                                    <div class="col-3">
                                        <label class="form-label">Periodo</label>
                                        <input type="text" class="form-control" value="<?= $campos_evento_selecionado['Interval field'] ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12">
                                    <label class="form-label">Descrição Evento</label>
                                    <textarea style="resize: none" rows="2" type="text" class="form-control" disabled><?= $campos_event_Scheduler['event_desc'] ?></textarea>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-4">
                                        <label class="form-label">Inicio</label>
                                        <input type="text" class="form-control" value="<?= $campos_evento_selecionado['Starts'] ?>" disabled>
                                    </div>

                                    <div class="col-4">
                                        <label class="form-label">Fim</label>
                                        <input type="text" class="form-control" value="<?= $campos_evento_selecionado['Ends'] ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <hr class="sidebar-divider">

                            <span>Informações do chamado</span>

                            <div class="col-lg-6">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Assunto chamado</label>
                                        <input type="text" class="form-control" value="<?= $campos_event_Scheduler['event_name'] ?>" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Tipo chamado</label>
                                        <input type="text" class="form-control" value="<?= $campos_event_Scheduler['tipo_chamado'] ?>" disabled>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">Empresa</label>
                                        <input type="text" class="form-control" value="<?= $campos_event_Scheduler['fantasia'] ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">Relato inicial</label>
                                        <textarea style="resize: none" rows="5" type="text" class="form-control" disabled><?= $campos_event_Scheduler['chamado_relato'] ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-8"></div>

                            <div class="col-2">
                                <input style="text-align: center;" type="text" class="form-control" value="<?= $campos_evento_selecionado['Status'] ?>" disabled>
                            </div>

                            <div class="col-2" style="text-align: right;">
                                <a onclick="return confirm('Tem certeza que deseja deletar este evento?')" href="processa/delete.php?idEvent=<?= $idEvent ?>"><input type="button" class="btn btn-warning" value="Excluir evento"></input></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require "../../includes/footer.php"
?>