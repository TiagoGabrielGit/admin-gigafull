<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$menu_id = "29";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_menu = $menu_id";
$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {
    $tarefa_id = $_GET['id'];

    $consulta_tarefa =
        "SELECT *
FROM tarefas
WHERE id = :tarefa_id
";

    $stmt_tarefa = $pdo->prepare($consulta_tarefa);
    $stmt_tarefa->execute(['tarefa_id' => $tarefa_id]);
    $tarefa = $stmt_tarefa->fetch(PDO::FETCH_ASSOC);
?>

    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>Tarefa - <?php echo htmlspecialchars($tarefa['descricao']); ?></h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <h3 class="card-title">Detalhes da Tarefa</h3>
                        </div>
                        <div class="col-3">
                            <a href="/tarefas/quadros.php?id=<?= $tarefa['quadro_id'] ?>"><button style="margin-top: 15px;" class="btn btn-sm btn-danger">Voltar ao Quadro</button></a>
                        </div>
                    </div>
                    <form action="update_tarefa.php" method="POST">
                        <input hidden readonly name="tarefa_id" value="<?= $tarefa['id'] ?>">

                        <div class="row">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Descrição</label>
                                <input class="form-control" id="descricao" name="descricao" value="<?= $tarefa['descricao'] ?>"></input>
                            </div>
                            <div class="col-2">
                                <label for="orcamento" class="form-label">Orçamento</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" id="orcamento" name="orcamento" value="<?= $tarefa['orcamento'] ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1" <?= ($tarefa['status'] == 1) ? 'selected' : '' ?>>Andamento</option>
                                    <option value="2" <?= ($tarefa['status'] == 2) ? 'selected' : '' ?>>Concluído</option>
                                    <option value="3" <?= ($tarefa['status'] == 3) ? 'selected' : '' ?>>Cancelado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="form-label" for="area_planejamento"><b>Área de Planejamento</b></label>
                            <textarea rows="20" id="area_planejamento" name="area_planejamento" class="form-control"><?= htmlspecialchars($tarefa['area_planejamento'] ?? '') ?></textarea>

                        </div>
                        <br><br>
                        <div class="text-center">
                            <button class="btn btn-sm btn-danger" type="submit">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>