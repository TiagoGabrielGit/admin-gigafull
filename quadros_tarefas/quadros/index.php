<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "60";
$uid = $_SESSION['id'];

$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    // Receber filtros
    $filtro_quadro = isset($_GET['filtro_quadro']) ? $_GET['filtro_quadro'] : '';
    $filtro_status = isset($_GET['filtro_status']) ? $_GET['filtro_status'] : '%';

    // Construir query SQL com filtros
    $sql = "SELECT id, titulo, created, status FROM quadros WHERE titulo LIKE :filtro_quadro AND status LIKE :filtro_status ORDER BY titulo";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'filtro_quadro' => "%$filtro_quadro%",
        'filtro_status' => $filtro_status
    ]);
    $quadros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Função para contar o número de tarefas em um quadro
    function contarTarefas($pdo, $quadroId)
    {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM tarefas WHERE quadro_id = :quadro_id");
        $stmt->execute(['quadro_id' => $quadroId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
?>

    <!-- O restante do código HTML permanece o mesmo -->
    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>QUADROS</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Adicionar Quadro</h3>

                    <form method="post" action="../processa/novo_quadro.php">
                        <div class="row">
                            <div class="col-8">
                                <input class="form-control" type="text" name="novo_quadro" required>
                            </div>
                            <div class="col-4">
                                <button style="margin-top: 5px;" type="submit" class="btn btn-danger btn-sm">Adicionar Quadro</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quadros de Tarefas</h5>

                    <form method="get" action="index.php">
                        <div class="row">
                            <div class="col-4">
                                <label for="filtro_quadro" class="form-label">Quadro</label>
                                <input id="filtro_quadro" name="filtro_quadro" class="form-control" value="<?= isset($_GET['filtro_quadro']) ? htmlspecialchars($_GET['filtro_quadro']) : '' ?>"></input>
                            </div>
                            <div class="col-2">
                                <label for="filtro_status" class="form-label">Status</label>
                                <select class="form-select" id="filtro_status" name="filtro_status">
                                    <option value="%" <?= !isset($_GET['filtro_status']) || $_GET['filtro_status'] == '%' ? 'selected' : '' ?>>Todos</option>
                                    <option value="1" <?= isset($_GET['filtro_status']) && $_GET['filtro_status'] == '1' ? 'selected' : '' ?>>Aberto</option>
                                    <option value="2" <?= isset($_GET['filtro_status']) && $_GET['filtro_status'] == '2' ? 'selected' : '' ?>>Arquivado</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-sm btn-info" style="margin-top: 32px;" type="submit">Filtrar Quadros</button>
                            </div>
                        </div>
                    </form>

                    <hr class="sidebar-divider">
                    <div class="list-group mt-3" id="taskList">
                        <?php foreach ($quadros as $quadro) :
                            $createdDate = date("d/m/Y", strtotime($quadro['created']));
                            $statusMap = [
                                1 => "Aberto",
                                2 => "Arquivado"
                            ];
                            $status = $statusMap[$quadro['status']];
                        ?>
                            <a href="quadros_view.php?id=<?=$quadro['id'] ?>" class="list-group-item list-group-item-action" data-id="<?php echo $quadro['id']; ?>">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($quadro['titulo']); ?></h5>
                                    <small class="text-muted">Criada em: <?php echo $createdDate; ?></small>
                                </div>
                                <p class="mb-1">Status: <?php echo $status; ?></p>
                                <small class="text-muted">Tarefas: <?php echo contarTarefas($pdo, $quadro['id']); ?> </small>
                            </a>
                        <?php endforeach; ?>
                    </div>
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