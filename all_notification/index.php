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
                        <?php
                        $consulta_notificacoes = "SELECT sn.mensagem_tipo as mensagem_tipo, sn.mensagem as mensagem, sn.id as id, sn.chamado_id as chamado_id, sn.relato_id as relato_id, DATE_FORMAT(sn.date, '%d/%m/%Y %H:%i') as formatted_date
                            FROM smart_notification as sn
                            WHERE sn.usuario_id = $usuario_id AND sn.status = 1
                            ORDER BY sn.id DESC";
                        $stmt = $pdo->prepare($consulta_notificacoes);
                        $stmt->execute();
                        ?>

                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                            <br>
                            <div class="list-group">
                                <div class="list-group-item list-group-item-warning">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-left">
                                            <b><?=  $row['mensagem'] ?></b><br>
                                            <?= $row['formatted_date'] ?>
                                        </div>
                                        <div class="text-right">
                                            <a href="/includes/processa/marcar_como_lido.php?id=<?= $row['id'] ?>" class="btn btn-info rounded-pill" style="padding: 3px 10px; font-size: 10px;">Marcar como Lido</a>
                                            <?php if ($row['mensagem_tipo'] == 3) : ?>
                                                <a href="/includes/processa/ir_para_chamado.php?id=<?= $row['id'] ?>" class="btn btn-info rounded-pill" style="padding: 3px 10px; font-size: 10px;">Ir para Chamado</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if ($row['mensagem_tipo'] == 3) : ?>
                                        <div>
                                            <?php
                                            $relato_id = $row['relato_id'];
                                            $query = "SELECT cr.relato, c.assuntoChamado 
                                                FROM chamado_relato as cr 
                                                LEFT JOIN chamados as c ON c.id = cr.chamado_id
                                                WHERE cr.id = :relato_id";
                                            $stmt_relato = $pdo->prepare($query);
                                            $stmt_relato->bindParam(':relato_id', $relato_id, PDO::PARAM_INT);
                                            $stmt_relato->execute();
                                            $relato = $stmt_relato->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <br>
                                            <b>Chamado: </b> <?= $relato['assuntoChamado'] ?> <br>
                                            <b>Relato</b><br>
                                            <?= $relato['relato'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "../includes/footer.php";
?>