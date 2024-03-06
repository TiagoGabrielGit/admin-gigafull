<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "49";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";
$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    $equipe_id = $_SESSION['equipe_id'];
    $id_chamado = $_GET['id'];

    $query_chamado =
        "SELECT
        f.status as afericao_status,
        c.in_execution_start as in_execution_start,
        c.in_execution as in_execution,
        tc.tipo as tipo,
        c.assuntoChamado as assunto,
        e.fantasia as empresa,
        p.nome as solicitante_nome,
        pes.nome as atendente_nome,
        c.data_prevista_conclusao as 'data_prevista_conclusao',
        s.service as service,
        ise.item as itemService,
        date_format(c.data_abertura,'%H:%i:%s %d/%m/%Y') as abertura,
        date_format(c.data_fechamento,'%H:%i:%s %d/%m/%Y') as fechado,
        c.atendente_id as id_atendente,

        cs.status_chamado as status,
        c.tipochamado_id as tipochamado_id

        FROM chamados as c
        LEFT JOIN afericao as f ON f.chamado_id = c.id
        LEFT JOIN tipos_chamados as tc ON c.tipochamado_id = tc.id
        LEFT JOIN chamados_status as cs ON c.status_id = cs.id

        LEFT JOIN empresas as e ON e.id = c.empresa_id
        LEFT JOIN usuarios as u ON u.id = c.solicitante_id 
        LEFT JOIN pessoas as p ON p.id = u.pessoa_id
        LEFT JOIN usuarios as us ON us.id = c.atendente_id
        LEFT JOIN pessoas as pes ON pes.id = us.pessoa_id
        LEFT JOIN contract_service as cser ON cser.id = c.service_id
        LEFT JOIN service as s ON s.id = cser.service_id
        LEFT JOIN contract_iten_service as cis ON cis.id = c.iten_service_id
        LEFT JOIN iten_service as ise ON ise.id = cis.iten_service

        WHERE c.id = '$id_chamado'";

    $r_chamado = mysqli_query($mysqli, $query_chamado);

    if (mysqli_num_rows($r_chamado) > 0) {
        $chamado = mysqli_fetch_assoc($r_chamado);


        if ($chamado['in_execution'] == 1) {
            $classeColor = "playColor";
        } else {
            $classeColor = "";
        }

        if ($chamado['data_prevista_conclusao'] !== null) {
            $dataPrevistaConclusao = strtotime($chamado['data_prevista_conclusao']); // Data prevista em formato timestamp
        }

?>
        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Chamado #<?= $id_chamado ?></h1>
            </div>

            <section class="section">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-9">
                                <div class="col-12">
                                    <h5 class="card-title <?= $classeColor ?>">
                                        <p>Chamado <?= $id_chamado ?> - <?= $chamado['tipo']; ?> - <?= $chamado['assunto']; ?></p>
                                    </h5>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="col-12">
                                        <?php
                                        $calc_tempo_total =
                                            "SELECT SUM(seconds_worked) as secondsTotal
                                                    from chamados
                                                    where id = $id_chamado";

                                        $seconds_total = mysqli_query($mysqli, $calc_tempo_total);
                                        $res_second = $seconds_total->fetch_array();
                                        ?>
                                        <b>Tipo Chamado:</b> <?= $chamado['tipo']; ?> <br>
                                        <b>Empresa:</b> <?= $chamado['empresa']; ?> <br>
                                        <b>Solicitante:</b> <?= $chamado['solicitante_nome']; ?><br>
                                        <b>Atendente:</b> <?= $chamado['atendente_nome'] ?><br>
                                        <b>Tempo total de atendimento:</b> <?= gmdate("H:i:s", $res_second['secondsTotal']); ?> <br>
                                        <br>
                                        <?php if ($chamado['data_prevista_conclusao'] === null) {
                                        } else {
                                            if ($chamado['status'] != "Fechado") { ?>
                                                <span title="Data prevista de conclusão" class="btn btn-small btn-<?= $colorPill ?> rounded-pill"><?= date('d/m/Y H:i:s', strtotime($chamado['data_prevista_conclusao'])) ?></span>
                                            <?php } else { ?>
                                                <span title="Data prevista de conclusão" class="btn btn-small btn-secondary rounded-pill"><?= date('d/m/Y H:i:s', strtotime($chamado['data_prevista_conclusao'])) ?></span>
                                            <?php }
                                            ?>
                                        <?php } ?>

                                        <?php if (isset($chamado['prioridade'])) { ?>
                                            <span class="badge bg-warning  text-dark">Prioridade: <?= $chamado['prioridade'] ?></span>
                                        <?php } ?>


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

                                <?php
                                $valida_competencia =
                                    "SELECT cc.competencia_id as competencia_id
                                    FROM chamados_competencias as cc
                                    WHERE cc.chamado_id = $id_chamado
                                    AND NOT EXISTS (
                                    SELECT id_competencia
                                    FROM usuario_competencia as uc
                                    WHERE uc.id_usuario = $uid
                                    AND uc.id_competencia = cc.competencia_id)";

                                $r_valida_competencia = mysqli_query($mysqli, $valida_competencia);
                                $r_valida_competencia2 = mysqli_query($mysqli, $valida_competencia);
                                $c_valida_competencia = $r_valida_competencia->fetch_array();
                                $c_valida_competencia2 = $r_valida_competencia2->fetch_array();

                                ?>
                                <div class="col-lg-4 text-center">
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="/servicedesk/chamados/visualizar_chamado.php?id=<?= $id_chamado ?>">
                                                <button type="button" class="btn btn-sm btn-danger">
                                                    Voltar ao chamado
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12 " style="margin-top: 5px;">
                                            <?php
                                            $tipochamado_id = $chamado['tipochamado_id'];
                                            $query = "SELECT * FROM chamados_autorizados_atender WHERE tipo_id = :tipo_id AND equipe_id = :equipe_id";
                                            $stmt = $pdo->prepare($query);
                                            $stmt->bindParam(':tipo_id', $tipochamado_id, PDO::PARAM_INT);
                                            $stmt->bindParam(':equipe_id', $equipe_id, PDO::PARAM_INT);
                                            $stmt->execute(); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="POST" id="relatarChamado" class="row g-3">
                            <span id="msgRelatar"></span>
                            <input readonly hidden id="chamadoID" name="chamadoID" value="<?= $id_chamado ?>"></input>
                            <input readonly hidden id="relatorID" name="relatorID" value="<?= $uid ?>"></input>
                            <input hidden id="startTime" name="startTime" value="<?= $chamado['in_execution_start']; ?>"></input>

                            <div class="col-4">
                                <label for="statusChamado" class="form-label">Status*
                                    <?php
                                    if ($chamado['afericao_status'] == 1) { ?>
                                        <span class="bi bi-info-circle info-icon" data-bs-toggle="tooltip" title="Não é possivel fechar o chamado se tiver uma aferição pendente."></span>
                                    <?php } ?>
                                </label>
                                <select class="form-select" id="statusChamado" name="statusChamado">
                                    <option selected value="2">Andamento</option>
                                    <?php
                                    if ($chamado['afericao_status'] != 1 || $chamado['afericao_status'] === NULL) {
                                        echo '<option value="3">Fechado</option>';
                                    }
                                    $sql_status_chamados =
                                        "SELECT cs.id as id_status, cs.status_chamado as status_chamado
                                        FROM chamados_status as cs
                                        WHERE cs.active = 1 and cs.id != 1 and cs.id != 2 and cs.id != 3
                                        ORDER BY cs.status_chamado ASC";
                                    $resultado = mysqli_query($mysqli, $sql_status_chamados);
                                    while ($status = mysqli_fetch_object($resultado)) :
                                        echo "<option value='$status->id_status'> $status->status_chamado</option>";
                                    endwhile;
                                    ?>
                                </select>
                            </div>
                            <div class="col-4"></div>
                            <div class="col-4">
                                <label for="privateChamado" class="form-label">Privacidade*</label>
                                <select class="form-select" id="privateChamado" name="privateChamado">
                                    <option selected value="">Selecione</option>
                                    <option value='1'> Público</option>
                                    <option value='2'> Privado</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="novoRelato" class="form-label">Relato*</label>
                                <textarea id="novoRelato" name="novoRelato" class="form-control" maxlength="10000" rows="20"></textarea>
                            </div>


                            <hr class="sidebar-divider">
                            <div class="row">
                                <div class="col-3">
                                    <button id="btnSalvarRascunho" class="btn btn-warning btn-sm">Salvar Rascunho</button>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-4">
                                    <span id="relatarLoading" hidden>
                                        <div class="spinner-border text-success" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </span>
                                    <input id="btnRelatar" name="btnRelatar" type="button" value="Relatar" class="btn btn-danger btn-sm"></input>
                                </div>
                                <div class="col-3">
                                    <a href="processa/cancelar_relato.php?idChamado=<?= $id_chamado ?>" class="btn btn-secondary btn-sm" onclick="confirmarCancelarRelato()">Cancelar Execução do Chamado</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            $(document).ready(function() {
                var rascunho = obterRascunhoRelato();

                $("#novoRelato").val(rascunho);

                $("body").click(function() {
                    salvarRascunho();
                });

                // Função para salvar o rascunho
                function salvarRascunho() {
                    var dadosRascunho = $("#relatarChamado").serialize();

                    $.post("/servicedesk/chamados/processa/rascunhoRelato.php", dadosRascunho, function(retorno) {

                    });
                }
            });
        </script>

        <script>
            var id_chamado = <?php echo json_encode($id_chamado); ?>;

            function obterRascunhoRelato() {
                var rascunho = '';
                $.ajax({
                    url: '/servicedesk/chamados/processa/obter_rascunho_relato.php',
                    type: 'POST',
                    async: false,
                    data: {
                        idChamado: id_chamado
                    },
                    success: function(response) {
                        rascunho = response;
                    }
                });
                return rascunho;
            }
        </script>


        <script>
            // btn relatar
            $("#btnRelatar").click(function() {
                document.querySelector("#btnRelatar").hidden = true;
                document.querySelector("#relatarLoading").hidden = false;
                var dadosRelatar = $("#relatarChamado").serialize();

                $.post("/servicedesk/chamados/processa/newRelato.php", dadosRelatar, function(retornaRelatar) {

                    if (retornaRelatar.includes("Error")) {
                        $("#msgRelatar").slideDown('slow').html(retornaRelatar);
                        document.querySelector("#btnRelatar").hidden = false;
                        document.querySelector("#relatarLoading").hidden = true;
                        retirarMsgRelatar();
                    } else if (retornaRelatar.includes("Success")) {
                        var dadosIDChamado = document.querySelector("#chamadoID").value;

                        $.post("/notificacao/telegram/relato_chamado.php", {
                            id_chamado: dadosIDChamado
                        }, function(responseNotifyTelegram) {

                        });

                        $.post("/notificacao/smart/relato_chamado.php", {
                            id_chamado: dadosIDChamado
                        }, function(responseNotifySmart) {

                        });

                        // Enviar o comando POST para notify_mail.php
                        $.post("/notificacao/mail/relato_chamado.php", {
                            id_chamado: dadosIDChamado
                        }, function(responseNotifyMail) {
                            if (retornaRelatar.includes("Success")) {
                                excluiRascunho();
                                $('#relatarChamado')[0].reset();
                                $("#basicModal").modal('hide');
                                redirecionarPagina();
                            }
                        });
                    }
                });
            });

            function retirarMsgRelatar() {
                setTimeout(function() {
                    $("#msgRelatar").slideUp('slow', function() {});
                }, 1700);
            };
        </script>

        <script>
            function redirecionarPagina() {
                window.location.href = '/servicedesk/chamados/visualizar_chamado.php?id=<?= $id_chamado ?>';
            }
        </script>

        <script>
            function confirmarCancelarRelato() {
                if (confirm("Tem certeza que deseja cancelar a execução do chamado?")) {
                    // O usuário clicou em 'OK', prosseguir com o cancelamento do relato
                    return true;
                } else {
                    // O usuário clicou em 'Cancelar', cancelar a ação
                    return false;
                }
            }
        </script>

        <script>
            function excluiRascunho() {
                var dadosRascunhoRelatoExcluir = $("#relatarChamado").serialize();
                $.post("/servicedesk/chamados/processa/excluirRascunhoRelato.php", dadosRascunhoRelatoExcluir);
            };
        </script>

<?php
    } else {
        require "../../acesso_negado.php";
    }
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
