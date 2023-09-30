<?php
require "../../../includes/menu.php";
require "../../../includes/remove_setas_number.php";
require "../../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];
$submenu_id = "36";

$permissions =
    "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    $idManutencao = $_GET['id'];

    $queryManutencao = "SELECT
    mp.id as idManutencao,
    mp.titulo as titulo,
    mp.dataAgendamento as dataAgendamento,
    mp.duracao as duracao,
    mp.descricao as descricao,
    mp.mensagem as mensagem,
    mp.active as status
    FROM
    manutencao_programada as mp
    WHERE 
    id = :idManutencao";


    $stmtManutencao = $pdo->prepare($queryManutencao);
    $stmtManutencao->bindParam(":idManutencao", $idManutencao, PDO::PARAM_INT);
    $stmtManutencao->execute();
    $manutencaoData = $stmtManutencao->fetch(PDO::FETCH_ASSOC);
    $id = $manutencaoData['idManutencao'];
    $titulo = $manutencaoData['titulo'];
    $dataAgendamento = $manutencaoData['dataAgendamento'];
    $duracao = $manutencaoData['duracao'];
    $descricao = $manutencaoData['descricao'];
    $mensagem = $manutencaoData['mensagem'];
    $status = $manutencaoData['status'];


?>

    <style>
        #tabelaLista:hover {
            cursor: pointer;
            background-color: #E0FFFF;
        }
    </style>
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
                                        <div class="d-inline-block">
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalGPON">
                                                GPON Afetados
                                            </button>
                                        </div>
                                        <div class="d-inline-block">
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalRF">
                                                Rotas Fibras Afetadas
                                            </button>
                                        </div>
                                        <div class="d-inline-block">
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalComunicados">
                                                Comunicados
                                            </button>
                                        </div>
                                        <?php if ($status == 3) { ?>
                                            <a href="/servicedesk/manutencao_programada/agendar_manutencao/index.php?id=<?= $id ?>" class="btn btn-sm btn-danger">Continuar Agendamento</a>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                            <hr class="sidebar-divider">
                            <br>
                            <form method="POST" action="processa/atualizar_manutencao_programada.php" class="row g-3">
                                <input name="idMP" id="idMP" readonly hidden value="<?= $idManutencao ?>"></input>

                                <div class="row">
                                    <div class="col-5">
                                        <label for="tituloMP" class="form-label">Titulo</label>
                                        <input value="<?= $titulo ?>" name="tituloMP" type="text" class="form-control" id="tituloMP" required>
                                    </div>

                                    <div class="col-3">
                                        <label for="dataAgendamentoMP" class="form-label">Data Agendamento</label>
                                        <input value="<?= $dataAgendamento ?>" name="dataAgendamentoMP" type="datetime-local" class="form-control" id="dataAgendamentoMP" required>
                                    </div>

                                    <div class="col-2">
                                        <label for="duracaoMP" class="form-label">Duração (em horas)</label>
                                        <input value="<?= $duracao ?>" name="duracaoMP" type="number" class="form-control" id="duracaoMP" required>
                                    </div>
                                    <div class="col-2">
                                        <label for="statusMP" class="form-label">Status</label>
                                        <select class="form-select" required name="statusMP" id="statusMP">
                                            <option value="0" <?php if ($status == 0) echo ' selected="selected"'; ?>>Cancelada</option>
                                            <option value="1" <?php if ($status == 1) echo ' selected="selected"'; ?>>Programada</option>
                                            <option value="2" <?php if ($status == 2) echo ' selected="selected"'; ?>>Concluída</option>
                                            <option disabled value="0" <?php if ($status == 3) echo ' selected="selected"'; ?>>Rascunho</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label for="descricaoMP" class="form-label">Descrição</label>
                                        <textarea id="descricaoMP" name="descricaoMP" class="form-control" style="height: 100px"><?= $descricao ?></textarea>
                                    </div>
                                </div>
                                <?php
                                if ($status == 1) { ?>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-danger">Salvar Alterações</button>
                                    </div>
                                <?php }
                                ?>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->


    <div class="modal fade" id="modalGPON" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">GPON Afetados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
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
    </div><!-- End Basic Modal-->

    <div class="modal fade" id="modalRF" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rotas de Fibra Afetados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
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
    </div><!-- End Basic Modal-->

    <div class="modal fade" id="modalComunicados" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comunicados Enviados</h5>

                    <form method="POST" action="processa/comunica_interessados.php" class="d-inline-block">
                        <input value="<?= $id ?>" id="idMPG" name="idMPG" hidden readonly>
                        <button type="submit" class="btn btn-sm btn-success">Enviar Comunicado</button>
                    </form>

                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <?php
                        $comunicados = "SELECT
                   CASE
                       WHEN ct.titulo IS NULL THEN 'Sem Template Vinculado'
                       ELSE ct.titulo
                   END as titulo,
                   p.nome as usuario,
                   c.id as idCom,
                   DATE_FORMAT(c.created, '%d/%m/%Y %H:%i:%s') as criado,
                   CASE
                       WHEN status = 0 THEN 'Cancelada'
                       WHEN status = 1 THEN 'Rascunho'
                       WHEN status = 2 THEN 'Enviada'
                   END as status
               FROM comunicacao as c
               LEFT JOIN usuarios as u ON u.id = c.usuario_criador
               LEFT JOIN pessoas as p ON p.id = u.pessoa_id
               LEFT JOIN comunicacao_templates as ct ON ct.id = c.template_email
               WHERE c.origem_id = $idManutencao
               ORDER BY c.id desc
               ";

                        try {
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $pdo->prepare($comunicados);
                            $stmt->execute();
                            $c_comunicados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Erro na consulta SQL: " . $e->getMessage();
                        }
                        // Verifique se há resultados antes de criar a tabela
                        if (!empty($c_comunicados)) {
                            echo '<table class="table datatable">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Template</th>';
                            echo '<th>Usuário</th>';
                            echo '<th>Criado Em</th>';
                            echo '<th>Status</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            foreach ($c_comunicados as $comunicado) { ?>
                                <tr id="tabelaLista" onclick="location.href='/comunicacao/gerenciar_comunicados/view_comunicacao.php?id=<?= $comunicado['idCom'] ?>'">
                                    <td><?= $comunicado['titulo'] ?></td>
                                    <td><?= $comunicado['usuario'] ?></td>
                                    <td><?= $comunicado['criado'] ?></td>
                                    <td><?= $comunicado['status'] ?></td>
                                </tr>
                        <?php }

                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo 'Nenhum resultado encontrado.';
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- End Basic Modal-->

<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>