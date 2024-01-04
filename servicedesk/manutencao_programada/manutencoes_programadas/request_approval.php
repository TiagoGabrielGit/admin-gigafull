<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";

// Obtenha o token da consulta GET
$token = $_GET['token'];

// Crie a consulta SQL com uma condição WHERE
$consultaMP =
    "SELECT mp.id as id, mp.descricao as descricao, mp.titulo as titulo, mp.dataAgendamento as dataAgendamento, mp.duracao as duracao, mp.responsavel_name as responsavel_name, mp.responsavel_contato as responsavel_contato, mpa.status as status
FROM manutencao_programada_aprovacao as mpa 
LEFT JOIN manutencao_programada as mp ON mp.id = mpa.id_manutencao
WHERE mpa.token = :token";

try {
    $stmt = $pdo->prepare($consultaMP);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $titulo = $resultados[0]['titulo'];
    $descricao = $resultados[0]['descricao'];
    $dataAgendamento = $resultados[0]['dataAgendamento'];
    $duracao = $resultados[0]['duracao'];
    $responsavel_name = $resultados[0]['responsavel_name'];
    $responsavel_contato = $resultados[0]['responsavel_contato'];
    $idManutencao  = $resultados[0]['id'];
    $status  = $resultados[0]['status'];
} catch (PDOException $e) {
    echo "Erro na consulta: " . $e->getMessage();
}
?>


<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="row">
                                <div class="text-left">
                                    <h5 class="card-title">Manutenção Programada</h5>
                                </div>
                                <div class="text-end">
                                    <?php if ($status == 1) { ?>

                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalAprovacao">
                                            Clique aqui para responder
                                        </button>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <hr class="sidebar-divider">
                        <br>
                        <div class="row">
                            <div class="col-5">
                                <label for="tituloMP" class="form-label">Titulo</label>
                                <input readonly maxlength="100" value="<?= $titulo ?>" name="tituloMP" type="text" class="form-control" id="tituloMP" required>
                            </div>

                            <div class="col-3">
                                <label for="dataAgendamentoMP" class="form-label">Data Agendamento</label>
                                <input readonly value="<?= $dataAgendamento ?>" name="dataAgendamentoMP" type="datetime-local" class="form-control" id="dataAgendamentoMP" required>
                            </div>

                            <div class="col-2">
                                <label for="duracaoMP" class="form-label">Duração (em horas)</label>
                                <input readonly value="<?= $duracao ?>" name="duracaoMP" type="number" class="form-control" id="duracaoMP" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-5">
                                <label for="responsavel_name" class="form-label">Responsável pela Manutenção</label>
                                <input readonly maxlength="150" value="<?= $responsavel_name ?>" name="responsavel_name" type="text" class="form-control" id="responsavel_name" required>
                            </div>
                            <div class="col-4">
                                <label for="responsavel_contato" class="form-label">Contato do Responspável pela Manutenção</label>
                                <input readonly name="responsavel_contato" value="<?= $responsavel_contato ?>" type="text" class="form-control" id="celular" required>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <label for="descricaoMP" class="form-label">Descrição</label>
                                <textarea readonly rows="10" maxlength="500" id="descricaoMP" name="descricaoMP" class="form-control" style="height: 100px"><?= $descricao ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="text-left">
                                            <h5 class="card-title">GPON Afetados</h5>
                                            <hr class="sidebar-divider">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul>
                                        <?php
                                        $gpon = "SELECT
                                                mg.id as idMan,
                                                gp.slot as slot,
                                                gp.pon as pon,
                                                gpo.olt_name as olt_name
                                                FROM manutencao_gpon as mg
                                                LEFT JOIN gpon_pon as gp ON gp.id = mg.pon_id
                                                LEFT JOIN gpon_olts as gpo ON gpo.id = gp.olt_id
                                                WHERE
                                                mg.manutencao_id = $idManutencao";

                                        try {
                                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $stmt = $pdo->prepare($gpon);
                                            $stmt->execute();
                                            $pons = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        } catch (PDOException $e) {
                                            echo "Erro na consulta SQL: " . $e->getMessage();
                                        }

                                        foreach ($pons as $pon) :
                                        ?>
                                            <li>
                                                <label class="form-check-label">
                                                    <?= "OLT " . $pon['olt_name'] . " (SLOT " . $pon['slot'] . " | PON " .  $pon['pon'] . ")" ?>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="text-left">
                                            <h5 class="card-title">Rotas de Fibras Afetadas</h5>
                                            <hr class="sidebar-divider">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul>
                                        <?php
                                        $rotas = "SELECT
                                                mrf.id as idMan,
                                                rf.ponta_a as ponta_a,
                                                rf.ponta_b as ponta_b
                                                FROM
                                                manutencao_rotas_fibra as mrf
                                                LEFT JOIN
                                                rotas_fibra as rf
                                                ON rf.id = mrf.rota_id
                                                WHERE
                                                mrf.manutencao_id = $idManutencao";

                                        try {
                                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $stmt = $pdo->prepare($rotas);
                                            $stmt->execute();
                                            $c_rotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        } catch (PDOException $e) {
                                            echo "Erro na consulta SQL: " . $e->getMessage();
                                        }

                                        foreach ($c_rotas as $rota) :
                                        ?>
                                            <li>
                                                <label class="form-check-label">
                                                    <?= $rota['ponta_a'] . " <> " .  $rota['ponta_b']  ?>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<div class="modal fade" id="modalAprovacao" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Solicitação de Aprovação</h5>
                <?php if ($status == 1) { ?>
                    <form method="POST" action="/notificacao/mail/envia_aprovacao_mp.php" class="d-inline-block" id="aprovacaoForm">
                        <input value="<?= $id ?>" id="aprovacao_id_mp" name="aprovacao_id_mp" hidden readonly>
                        <button type="button" id="enviarSolicitacao" class="btn btn-sm btn-success">Enviar Solicitação de Aprovação</button>
                        <button type="button" id="loadingButton" class="btn btn-sm btn-info" style="display: none;" disabled>Carregando...</button>
                    </form>
                <?php } ?>
            </div>

            <script>
                document.getElementById('enviarSolicitacao').addEventListener('click', function() {
                    // Oculta o botão original e exibe o botão de carregamento
                    document.getElementById('enviarSolicitacao').style.display = 'none';
                    document.getElementById('loadingButton').style.display = 'inline-block';

                    var form = document.getElementById('aprovacaoForm');
                    var formData = new FormData(form);

                    var xhr = new XMLHttpRequest();

                    xhr.open('POST', '/notificacao/mail/envia_aprovacao_mp.php', true);
                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            // A resposta foi bem-sucedida, exiba a resposta no elemento de alerta
                            document.getElementById('resposta').classList.remove('d-none');
                            document.getElementById('resposta').innerHTML = 'Envio realizado com sucesso!';
                        } else {
                            // A resposta não foi bem-sucedida; lide com o erro, se necessário.
                            console.error('Erro ao enviar solicitação de aprovação.');
                        }

                        // Oculta o botão de carregamento e exibe o botão original novamente
                        document.getElementById('loadingButton').style.display = 'none';
                        document.getElementById('enviarSolicitacao').style.display = 'inline-block';
                    };

                    xhr.send(formData);
                });
            </script>




            <div class="modal-body">
                <div class="card-body">

                    <div id="resposta" class="alert alert-warning alert-dismissible fade show d-none" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>



                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="text-align:  center;">Nome</th>
                                <th style="text-align:  center;">E-mail</th>
                                <th style="text-align:  center;">Data Envio</th>
                                <th style="text-align:  center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $solicitacoes_enviadas =
                                "SELECT mpa.id as id, mpra.email, mpra.nome as nome, mpa.status as statusID,
                                    CASE
                                    WHEN mpa.status = 1 THEN 'Aguardando Aprovação'
                                    END as status,
                                    DATE_FORMAT(mpa.date_send, '%d/%m/%Y %H:%i') as data_envio
                                        FROM manutencao_programada_aprovacao as mpa
                                        LEFT JOIN manutencao_programada_responsaveis_aceite as mpra ON mpra.id = mpa.contato_id
                                        WHERE mpa.id_manutencao = :id_manutencao
                                        ORDER BY mpra.nome ASC";

                            $stmt = $pdo->prepare($solicitacoes_enviadas);
                            $stmt->bindParam(':id_manutencao', $idManutencao);
                            $stmt->execute();
                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if (count($results) > 0) {
                                foreach ($results as $row) {
                                    if ($row['statusID'] == 1) {
                                        $bgCollor = "warning";
                                    }
                            ?>

                                    <tr>
                                        <td style="text-align:  center;"><?= $row['nome'] ?></td>
                                        <td style="text-align:  center;"><?= $row['email'] ?></td>
                                        <td style="text-align:  center;"><?= $row['data_envio'] ?></td>
                                        <td style="text-align:  center;"><span class="badge bg-<?= $bgCollor ?>"><?= $row['status'] ?></span></td>
                                    </tr>
                            <?php }
                            } else {
                                echo '<tr><td colspan="4">Nenhum resultado encontrado.</td></tr>';
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require "../../../includes/securityfooter.php";

?>