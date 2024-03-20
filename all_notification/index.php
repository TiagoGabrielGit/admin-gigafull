<?php
require "../includes/menu.php";
require "../conexoes/conexao_pdo.php";
$usuario_id = $_SESSION['id'];

if (isset($_SESSION['id'])) {
    // Inicializa a variável $tipos_selecionados com todos os IDs de tipos de chamados disponíveis
    $tipos_selecionados = [];

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepara a cláusula WHERE para a consulta SQL
        $where_clause = "";

        // Se não houver checkbox marcado, selecione todos
        if (!isset($_POST['tiposChamados'])) {
            $where_clause = "AND 1 = 1"; // Retorna sempre verdadeiro
        } else {
            // Se houver checkboxes marcados, monte a cláusula WHERE com os IDs
            $tipos_selecionados = $_POST['tiposChamados'];
            $where_clause = "AND tc.id IN (" . implode(",", $tipos_selecionados) . ")";
        }

        // Consulta SQL modificada para aplicar os filtros
        $consulta_notificacoes =
            "SELECT sn.mensagem_tipo as mensagem_tipo, sn.mensagem as mensagem, sn.id as id, sn.chamado_id as chamado_id, sn.relato_id as relato_id, DATE_FORMAT(sn.date, '%d/%m/%Y %H:%i') as formatted_date
            FROM smart_notification as sn
            LEFT JOIN chamados as c ON sn.chamado_id = c.id
            LEFT JOIN tipos_chamados as tc ON tc.id = c.tipochamado_id
            WHERE sn.usuario_id = $usuario_id AND sn.status = 1 $where_clause
            ORDER BY sn.id DESC";
        $stmt = $pdo->prepare($consulta_notificacoes);
        $stmt->execute();

        // Recupera os tipos de chamados selecionados para manter os checkboxes desmarcados
    } else {
        // Se o formulário não foi enviado, selecione todas as notificações
        $consulta_notificacoes =
            "SELECT sn.mensagem_tipo as mensagem_tipo, sn.mensagem as mensagem, sn.id as id, sn.chamado_id as chamado_id, sn.relato_id as relato_id, DATE_FORMAT(sn.date, '%d/%m/%Y %H:%i') as formatted_date
            FROM smart_notification as sn
            LEFT JOIN chamados as c ON sn.chamado_id = c.id
            WHERE sn.usuario_id = $usuario_id AND sn.status = 1
            ORDER BY sn.id DESC";
        $stmt = $pdo->prepare($consulta_notificacoes);
        $stmt->execute();
    }
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
                                <div class="text-left"></div>
                                <div class="text-right">
                                    <a href="/includes/processa/marcar_todos_como_lido.php?uid=<?= $usuario_id ?>" class="btn btn-info btn-sm" style="margin-top: 15px; padding: 3px 10px; font-size: 10px;">Marcar todos como lido</a>
                                </div>
                            </div>
                            <div style="margin-top: 30px;" class="text-left">
                                <form action="#" method="POST">
                                    <label for="tiposChamados" class="form-label"><b>Tipos de Chamados</b></label>
                                    <div class="row">
                                        <?php
                                        $tipos_chamados = "SELECT tc.id as idTipoChamado, tc.tipo as tipoChamado
                                            FROM chamados as c
                                            LEFT JOIN smart_notification as sn ON sn.chamado_id = c.id
                                            LEFT JOIN tipos_chamados as tc ON tc.id = c.tipochamado_id
                                            WHERE sn.usuario_id = $usuario_id AND sn.status = 1
                                            GROUP BY tc.id
                                            ORDER BY tc.tipo ASC";
                                        $stmtTipoChamado = $pdo->query($tipos_chamados);
                                        while ($rowTipoChamado = $stmtTipoChamado->fetch(PDO::FETCH_ASSOC)) {
                                            $idTipoChamado = $rowTipoChamado['idTipoChamado'];
                                            $tipoChamado = $rowTipoChamado['tipoChamado'];
                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                $checked = in_array($idTipoChamado, $tipos_selecionados) ? 'checked' : ''; // Verifica se o checkbox deve ser marcado

                                            } else {
                                                $checked = 'checked'; // Marca todos os checkboxes por padrão

                                            }

                                        ?>
                                            <div class="col-lg-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="tipochamado<?= $idTipoChamado ?>" name="tiposChamados[]" value="<?= $idTipoChamado ?>" <?= $checked ?>>
                                                    <label class="form-check-label" for="submenu<?= $idTipoChamado ?>"><?= $tipoChamado ?></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-sm btn-danger">Aplicar Filtros</button>
                                        </div>
                                    </div>
                                </form>

                            </div>


                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
                                <br>
                                <div class="list-group">
                                    <div class="list-group-item list-group-item-warning">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-left">
                                                <b><?= $row['mensagem'] ?></b><br>
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
} else {
    require "/index.php";
}
require "../includes/footer.php";
?>