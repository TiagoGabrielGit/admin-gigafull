<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require "sql.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Programar abertura de chamado</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-9">
                                    <h5 class="card-title">#</h5>
                                </div>
                                <div class="col-3">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#programarChamado">
                                            Programar chamado
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped" id="styleTable">
                            <thead>
                                <tr>
                                    <th scope="col">Empresa</th>
                                    <th scope="col">Evento</th>
                                    <th scope="col">Assunto Chamado</th>
                                    <th scope="col">Tipo Chamado</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $event_schedule =
                                    "SELECT
                                    es.id as id_event,
                                    es.event_name as event_name,
                                    es.chamado_assunto as chamado_assunto,
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
                                ORDER BY
                                    e.fantasia ASC,
                                    es.event_name ASC
                                ";
                                $r_event_schedule = mysqli_query($mysqli, $event_schedule);

                                while ($campos_event_Scheduler = $r_event_schedule->fetch_array()) {
                                    $event_name = $campos_event_Scheduler['event_name'];
                                    $event_id = $campos_event_Scheduler['id_event'];

                                    $sql_event = "SHOW EVENTS LIKE '$event_id'";
                                    $r_sql_event = mysqli_query($mysqli, $sql_event);
                                    $campos_event = $r_sql_event->fetch_array();
                                ?>
                                    <tr onclick="location.href='view.php?idEvent=<?= $campos_event_Scheduler['id_event']; ?>'">
                                        <td><?= $campos_event_Scheduler['fantasia']; ?></td>
                                        <td><?= $event_name ?></td>
                                        <td><?= $campos_event_Scheduler['chamado_assunto']; ?></td>
                                        <td><?= $campos_event_Scheduler['tipo_chamado']; ?></td>
                                        <td><?= $campos_event['Status']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
require "modalProgramarChamado.php";
require "processa/scripts.php";
require "../../includes/footer.php";
?>