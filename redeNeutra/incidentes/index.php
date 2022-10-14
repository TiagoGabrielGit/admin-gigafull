<?php
require "../../includes/menu.php";
require "sql.php";
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>INCIDENTES</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lista Incidentes</h5>

                        <div class="accordion" id="accordionFlushExample">

                            <?php
                            $r_sql_incidentes = mysqli_query($mysqli, $sql_incidentes);

                            $cont = 1;

                            while ($campos = $r_sql_incidentes->fetch_array()) {
                                $id_incidente = $campos['idIncidente'];
                                if ($campos['activeID'] == "1") {
                                    $estiloTable = "styleTableIncidentesAlarm";
                                    $corBandeira = "black";
                                } else if ($campos['activeID'] == "0") {
                                    $estiloTable = "styleTableIncidentesOK";
                                    $corBandeira = "black";
                                }
                            ?>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading<?= $cont ?>">
                                        <button class="accordion-button collapsed" id="<?= $estiloTable ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" stroke="black" fill="<?=$corBandeira?>" class="bi bi-flag-fill" viewBox="0 0 16 16">
                                                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001"></path>
                                            </svg> &nbsp; &nbsp; Incidente: <?= $campos['descricaoIncidente'] ?>
                                        </button>
                                    </h2>
                                    <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body colorAccordion">
                                            <div class="row justify-content-between">
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
                                                <div class="col-2">
                                                    <a href="/redeNeutra/incidentes/view.php?id=<?= $id_incidente ?>" title="Visualizar">
                                                        <button type="button" class="btn btn-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                            </svg>
                                                            Ver incidente
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
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
</main><!-- End #main -->

<script>
    setTimeout(function() {
        window.location.reload(1);
    }, 60000); //
</script>

<?php
require "../../includes/footer.php"
?>