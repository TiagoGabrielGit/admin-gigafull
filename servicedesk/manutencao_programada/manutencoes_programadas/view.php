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

    $titulo = $manutencaoData['titulo'];
    $dataAgendamento = $manutencaoData['dataAgendamento'];
    $duracao = $manutencaoData['duracao'];
    $descricao = $manutencaoData['descricao'];
    $mensagem = $manutencaoData['mensagem'];
    $status = $manutencaoData['status'];


?>
    <main id="main" class="main">

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Manutenção Programada</h3>

                            <hr class="sidebar-divider">

                            <br><br>

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
                                        </select>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label for="descricaoMP" class="form-label">Descrição</label>
                                        <textarea id="descricaoMP" name="descricaoMP" class="form-control" style="height: 100px"><?= $descricao ?></textarea>
                                    </div>

                                    <div class="col-6">
                                        <label for="mensagemMP" class="form-label">Mensagem</label>
                                        <textarea id="mensagemMP" name="mensagemMP" class="form-control" style="height: 100px"><?= $mensagem ?></textarea>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-danger">Salvar Alterações</button>
                                </div>
                            </form>
                            <hr class="sidebar-divider">

                            <li class="nav-heading" style="list-style: none;"><b>Pontos Afetados</b></li>

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Rotas de Fibra</h5>
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

                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">GPON</h5>
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
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->
<?php

} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>