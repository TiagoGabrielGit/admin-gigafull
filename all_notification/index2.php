<?php
require "../includes/menu.php";
require "../conexoes/conexao_pdo.php";
$usuario_id = $_SESSION['id'];
?>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-left">
                            </div>
                            <div class="text-right">
                                <a href="/includes/processa/marcar_todos_como_lido.php?uid=<?= $usuario_id ?>" class="btn btn-info btn-sm" style="margin-top: 15px; padding: 3px 10px; font-size: 10px;">Marcar todos como lido</a>
                            </div>
                        </div>
                        <ul class="list-group">
                            <?php
                            $consulta_notificacoes = "SELECT sn.mensagem_tipo as mensagem_tipo, sn.mensagem as mensagem, sn.id as id, sn.chamado_id as chamado_id, sn.relato_id as relato_id
                            FROM smart_notification as sn
                            WHERE sn.usuario_id = $usuario_id AND sn.status = 1
                            ORDER BY sn.id desc";

                            $stmt = $pdo->prepare($consulta_notificacoes);
                            $stmt->execute();

                            echo "<br>";
                            $count = '1';
                            while ($campos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $Color = "";
                                if ($campos['mensagem_tipo'] == 3) {
                                    $titulo_notificacao = "Novo relato adicionado";
                                    $Color = "list-group-item-warning";
                                }
                            ?>
                                <li class="list-group-item <?= $Color ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-left">
                                            <b><?= $campos['mensagem'] ?></b>
                                        </div>
                                        <div class="text-right">
                                            <a href="/includes/processa/marcar_como_lido.php?id=<?= $campos['id'] ?>" class="btn btn-info rounded-pill" style="padding: 3px 10px; font-size: 10px;">Marcar como Lido</a>
                                            <?php if ($campos['mensagem_tipo'] == 3) { ?>
                                                <a href="/includes/processa/ir_para_chamado.php?id=<?= $campos['id'] ?>" class="btn btn-info rounded-pill" style="padding: 3px 10px; font-size: 10px;">Ir para Chamado</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if ($campos['mensagem_tipo'] == 3) { ?>
                                        <br>
                                        <div>
                                            <?php
                                            $relato_id = $campos['relato_id'];
                                            $query = "SELECT cr.relato 
                                                FROM chamado_relato as cr 
                                                LEFT JOIN chamados as c ON c.id = cr.chamado_id
                                                WHERE cr.id = :relato_id";
                                            $stmt = $pdo->prepare($query);
                                            $stmt->bindParam(':relato_id', $relato_id, PDO::PARAM_INT);
                                            $stmt->execute();
                                            $relato = $stmt->fetch(PDO::FETCH_ASSOC);
                                            echo $count . '<b>Relato</b> ' . '<br>' . $relato['relato'];
                                            ?>
                                        </div>
                                    <?php
                                    } ?>
                                </li>
                            <?php
                                $count++;
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "../includes/footer.php";
?>