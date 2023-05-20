<style>
    .playColor {
        border-radius: 4px;
        background-color: #98FB98;
    }
</style>

<?php
if ($chamado['in_execution'] == 1) {
    $classeColor = "playColor";
} else {
    $classeColor = "";
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chamado #<?= $id_chamado ?></h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="justify-content-between <?= $classeColor ?>">

                                <div class="col-10">
                                    <h5 class="card-title">
                                        Chamado <?= $id_chamado ?> - <?= $chamado['tipo']; ?> - <?= $chamado['assunto']; ?>
                                    </h5>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="col-12">
                                                <?php
                                                $calc_tempo_total =
                                                    "SELECT SUM(seconds_worked) as secondsTotal
                                                    from chamados
                                                    where id = $id_chamado";

                                                $seconds_total = mysqli_query($mysqli, $calc_tempo_total);
                                                $res_second = $seconds_total->fetch_array();
                                                ?>

                                                <b>Empresa:</b> <?= $chamado['empresa']; ?> <br>
                                                <b>Solicitante:</b> <?= $solicitante['solicitante']; ?><br>
                                                <b>Atendente:</b> <?= $atendente ?><br>
                                                <b>Tempo total de atendimento:</b> <?= gmdate("H:i:s", $res_second['secondsTotal']); ?> <br>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="col-12">
                                                <b>Serviço: </b><?= $chamado['service']; ?><br>
                                                <b>Item de Serviço: </b><?= $chamado['itemService']; ?><br>
                                                <b>Data abertura: </b><?= $chamado['abertura']; ?> <br>
                                                <b>Data fechamento: </b><?= $chamado['fechado']; ?> <br>
                                                <b>Status: </b><?= $chamado['status']; ?> <br><br>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <?php
                                            if ($chamado['status'] != "Fechado") { ?>
                                                <div class="col-12">
                                                    <button style="margin-top: 15px" type="button" class="btn btn-danger row col-12" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                        Inserir um relato
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-8">
                                    <br><b>Descrição:</b><br>
                                    <?= nl2br($chamado['relato_inicial']); ?>
                                </div>

                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo relato</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <!--<form method="POST" action="processa/newRelato.php" class="row g-3 needs-validation">-->
                                                    <form method="POST" id="relatarChamado" class="row g-3">
                                                        <span id="msgSalvaRascunhoRelato"></span>
                                                        <span id="msgRelatar"></span>
                                                        <input hidden id="chamadoID" name="chamadoID" value="<?= $id_chamado ?>"></input>
                                                        <input hidden id="tipoUsuario" name="tipoUsuario" value="<?= $tipoUsuario ?>"></input>
                                                        <input hidden id="relatorID" name="relatorID" value="<?= $id_usuario ?>"></input>

                                                        <input hidden id="startTime" name="startTime" value="<?= $chamado['in_execution_start']; ?>"></input>


                                                        <div class="col-12">
                                                            <label for="novoRelato" class="form-label">Relato*</label>
                                                            <textarea id="novoRelato" name="novoRelato" class="form-control" maxlength="10000" rows="8"></textarea>
                                                        </div>

                                                        <hr class="sidebar-divider">
                                                        <div class="row">

                                                            <div class="col-5">

                                                            </div>
                                                            <div class="col-4">
                                                                <input id="btnRelatar" name="btnRelatar" type="button" value="Relatar" class="btn btn-danger"></input>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="accordion" id="accordionFlushExample">
                            <?php
                            $resultado_relatos = mysqli_query($mysqli, $sql_relatos)  or die("Erro ao retornar dados");
                            $cont = 1;
                            while ($campos = $resultado_relatos->fetch_array()) {
                                $id_relato = $campos['id_relato'];
                                $tempoAtendimento = gmdate("H:i:s", $campos['seconds_worked']);
                                $private = $campos['privacidade'];

                                if ($private == 1) { ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-heading<?= $cont ?>"> <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">Relato #<?= $id_relato ?> - <?= $campos['relatante']; ?></button></h2>
                                        <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <b>Relatante: </b> <?= $campos['relatante']; ?> <br>
                                                <b>Período: </b> <?= $campos['inicio']; ?> à <?= $campos['final']; ?><br>
                                                <b>Tempo de atendimento: </b> <?= $tempoAtendimento ?><br>
                                                <b>Privacidade: </b> <?php
                                                                        if ($private == 1) {
                                                                            echo "Público";
                                                                        } else {
                                                                            echo "Privado";
                                                                        };

                                                                        ?><br>
                                                <hr class="sidebar-divider">

                                                <b>Descrição: </b> <br><?= nl2br($campos['relato']); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                ?>


                            <?php $cont++;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "scripts/js_cliente.php";
require "../../includes/footer.php";
?>