<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "61";
$uid = $_SESSION['id'];

// Função para verificar permissões
function verificarPermissoes($pdo, $uid, $submenu_id)
{
    $query = "SELECT u.perfil_id
              FROM usuarios u
              JOIN perfil_permissoes_submenu pp
              ON u.perfil_id = pp.perfil_id
              WHERE u.id = :uid AND pp.url_submenu = :submenu_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':uid', $uid);
    $stmt->bindParam(':submenu_id', $submenu_id);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

// Função para buscar status
function buscarStatus($pdo, $status_id)
{
    $query = "SELECT * FROM tarefas_status WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $status_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Verificar permissões
if (verificarPermissoes($pdo, $uid, $submenu_id)) {
    // Verificar se o ID do status foi passado na URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $status_id = $_GET['id'];

        // Buscar os detalhes do status específico
        $status = buscarStatus($pdo, $status_id);

        if ($status) {
?>

            <main id="main" class="main">
                <section class="section">
                    <div class="pagetitle">
                        <h1>Editar Status de Tarefa</h1>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <h3 class="card-title">Status - <?= htmlspecialchars($status['titulo']) ?></h3>
                                    <?php if ($status['default'] == 1) { ?>
                                        <span>Este status é default do sistema, portanto sua edição é limitada.</span>
                                        <br>
                                    <?php } ?>

                                </div>

                                <div class="col-2">
                                    <a href="/quadros_tarefas/tarefas_status/index.php"><button style="margin-top: 20px;" class="btn btn-sm btn-danger">Listagem de Status</button></a>
                                </div>
                            </div>

                            <?php
                            if (isset($_SESSION['msg'])) { ?>
                                <br>
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['msg'] ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php
                                unset($_SESSION['msg']);
                            } ?>
                            <br>
                            <form method="POST" action="processa/atualizar_status.php">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($status['id']) ?>">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="form-label" for="status">Status</label>
                                        <input required class="form-control" id="status" name="status" value="<?= htmlspecialchars($status['titulo']) ?>"></input>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label" for="tipo_fechamento">Tipo Fechamento
                                            <span class="bi bi-info-circle info-icon" data-bs-toggle="tooltip" title="Se marcado como sim, quando uma tarefa receber este status não poderá mais ser editada."></span>
                                        </label>
                                        <?php if ($status['default'] == 1) { ?>
                                            <input class="form-control" readonly value="<?= $status['status_fechamento'] == 1 ? 'Sim' : 'Não' ?>"></input>
                                        <?php } else { ?>
                                            <select required class="form-select" id="tipo_fechamento" name="tipo_fechamento">
                                                <option disabled value="">Selecione</option>
                                                <option value="1" <?= $status['status_fechamento'] == 1 ? 'selected' : '' ?>>Sim</option>
                                                <option value="0" <?= $status['status_fechamento'] == 0 ? 'selected' : '' ?>>Não</option>
                                            </select>
                                        <?php } ?>
                                    </div>

                                    <div class="col-3">
                                        <label class="form-label" for="ativo">Ativo</label>
                                        <select required class="form-select" id="ativo" name="ativo">
                                            <option disabled value="">Selecione</option>
                                            <option value="1" <?= $status['active'] == 1 ? 'selected' : '' ?>>Ativo</option>
                                            <option value="0" <?= $status['active'] == 0 ? 'selected' : '' ?>>Inativo</option>
                                        </select>
                                    </div>

                                    <div class="col-2">
                                        <label for="statusColor" class="form-label">Cor Referência</label>
                                        <input required type="color" class="form-control form-control-color" name="statusColor" id="statusColor" value="<?= $status['color'] ?>">
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-7">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <textarea id="descricao" name="descricao" maxlength="255" rows="4" style="resize: none;" class="form-control"><?= $status['descricao'] ?></textarea>
                                    </div>

                                </div>
                                <br>
                                <div class="text-center">
                                    <button style="margin-top: 33px;" type="submit" class="btn btn-sm btn-danger">Atualizar Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </main>

<?php
        } else {
            echo "<div class='alert alert-danger'>Status não encontrado.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>ID do status inválido ou não fornecido.</div>";
    }
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>