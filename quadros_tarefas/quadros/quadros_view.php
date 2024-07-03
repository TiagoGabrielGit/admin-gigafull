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

    $quadro_id = $_GET['id'];

    // Receber filtros
    $filtro_tarefa = isset($_GET['filtro_tarefa']) ? $_GET['filtro_tarefa'] : '';
    $filtro_status = isset($_GET['filtro_status']) ? $_GET['filtro_status'] : '%';

    // Consultar informações do quadro
    $consulta_quadro = "SELECT titulo, status, id FROM quadros WHERE id = :quadro_id";
    $stmt_quadro = $pdo->prepare($consulta_quadro);
    $stmt_quadro->execute(['quadro_id' => $quadro_id]);
    $quadro = $stmt_quadro->fetch(PDO::FETCH_ASSOC);

    // Consultar tarefas com base nos filtros
    $consulta_tarefas =
        "SELECT t.id, t.descricao, t.ordem, t.created, t.status, ts.descricao as descricao_status, ts.titulo, ts.color
    FROM tarefas as t
    LEFT JOIN tarefas_status as ts ON ts.id = t.status
    WHERE t.quadro_id = :quadro_id 
    AND t.descricao LIKE :filtro_tarefa 
    AND t.status LIKE :filtro_status 
    ORDER BY t.ordem
";

    $stmt = $pdo->prepare($consulta_tarefas);
    $stmt->execute([
        'quadro_id' => $quadro_id,
        'filtro_tarefa' => "%$filtro_tarefa%",
        'filtro_status' => $filtro_status
    ]);
    $tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Função para contar o número de tarefas em um quadro (opcional se já foi definida antes)
    function contarTarefas($pdo, $quadroId)
    {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM tarefas WHERE quadro_id = :quadro_id");
        $stmt->execute(['quadro_id' => $quadroId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    $valor_quadro =
        "SELECT SUM(qd.valor) as total_valor
        FROM qt_despesas as qd
        LEFT JOIN tarefas as t ON t.id = qd.id_tarefa
        WHERE t.quadro_id = :quadro_id";
    $stmt_valor_quadro = $pdo->prepare($valor_quadro);
    $stmt_valor_quadro->bindParam(':quadro_id', $quadro_id, PDO::PARAM_INT);
    $stmt_valor_quadro->execute();
    $r_valor_quadro = $stmt_valor_quadro->fetch(PDO::FETCH_ASSOC);


    if ($r_valor_quadro && isset($r_valor_quadro['total_valor'])) {
        $total_valor_quadro = number_format((float)$r_valor_quadro['total_valor'], 2, ',', '.');
    } else {
        $total_valor_quadro = "0,00";
    }
?>

    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>Quadro - <?= htmlspecialchars($quadro['titulo']); ?></h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h3 class="card-title">Configurações do Quadro</h3>
                        </div>
                        <div class="col-2">
                            <a href="/quadros_tarefas/quadros/index.php"><button style="margin-top: 15px;" class="btn btn-sm btn-danger">Listagem de Quadros</button></a>
                        </div>
                    </div>
                    <form action="../processa/atualizar_quadro.php" method="POST">
                        <input id="id_quadro" name="id_quadro" value="<?= $quadro['id'] ?>" hidden readonly></input>
                        <div class="row">
                            <div class="col-4">
                                <label for="titulo" class="form-label">Titulo do Quadro</label>
                                <input class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($quadro['titulo']) ?>"></input>
                            </div>
                            <div class="col-3">
                                <label for="status" class="form-label">Status do Quadro</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="1" <?= $quadro['status'] == 1 ? 'selected' : '' ?>>Aberto</option>
                                    <option value="2" <?= $quadro['status'] == 2 ? 'selected' : '' ?>>Arquivado</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit" style="margin-top: 30px;" class="btn btn-sm btn-info">Atualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php if ($quadro['status'] == 1) { ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <h3 class="card-title">Adicionar Tarefa</h3>
                            </div>
                        </div>
                        <form method="post" action="../processa/adicionar_mover_tarefa.php">
                            <input type="hidden" name="quadro_id" value="<?php echo $quadro_id; ?>" required>
                            <div class="row">
                                <div class="col-8">
                                    <input class="form-control" type="text" name="new_task" required>
                                </div>
                                <div class="col-4">
                                    <button style="margin-top: 5px;" type="submit" class="btn btn-danger btn-sm">Adicionar Tarefa</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>

            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Lista de Tarefas</h3>
                    <div class="row">
                        <div class="col-lg-10">
                            <form method="get" action="quadros_view.php">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($quadro_id) ?>">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="filtro_tarefa" class="form-label">Descrição da Tarefa</label>
                                        <input id="filtro_tarefa" name="filtro_tarefa" class="form-control" value="<?= isset($_GET['filtro_tarefa']) ? htmlspecialchars($_GET['filtro_tarefa']) : '' ?>"></input>
                                    </div>
                                    <?php
                                    $sql = "SELECT id, descricao, titulo FROM tarefas_status WHERE active = 1";
                                    $stmt = $pdo->query($sql);
                                    $statusList = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="col-3">
                                        <label for="filtro_status" class="form-label">Status</label>
                                        <select class="form-select" id="filtro_status" name="filtro_status">
                                            <!-- Opção para selecionar todos os status -->
                                            <option value="%" <?= !isset($_GET['filtro_status']) || $_GET['filtro_status'] == '%' ? 'selected' : '' ?>>Todos</option>

                                            <!-- Gerando as opções dinamicamente a partir do banco de dados -->
                                            <?php foreach ($statusList as $status) : ?>
                                                <option value="<?= htmlspecialchars($status['id']) ?>" <?= isset($_GET['filtro_status']) && $_GET['filtro_status'] == $status['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($status['titulo']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <button class="btn btn-sm btn-info" style="margin-top: 32px;" type="submit">Filtrar Tarefas</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-2">
                            <div class="d-flex flex-column">
                                <input style="margin-bottom: 10px; text-align: center;" readonly disabled class="form-control flex-fill" value="<?= 'R$ ' . $total_valor_quadro ?>"></input>
                                <button id="toggleOrderBtn" class="btn btn-warning btn-sm mb-2 flex-fill">Destravar</button>
                                <a href="/tcpdf/export/relatorio_tarefas.php?id=<?= $quadro_id ?>" target="_blank" class="btn btn-info btn-sm flex-fill">
                                    Gerar PDF
                                </a>
                            </div>
                        </div>

                    </div>

                    <hr class="sidebar-divider">

                    <div class="list-group mt-3" id="taskList">
                        <?php foreach ($tarefas as $tarefa) :
                            $createdDate = date("d/m/Y", strtotime($tarefa['created']));
                            $id_tarefa = $tarefa['id'];

                            // Consulta para obter o total de despesas
                            $total_despesas_query = "SELECT SUM(valor) as total FROM qt_despesas WHERE active = 1 AND id_tarefa = :tarefa_id";
                            $stmt_despesas = $pdo->prepare($total_despesas_query);
                            $stmt_despesas->execute(['tarefa_id' => $id_tarefa]);
                            $total_despesas = $stmt_despesas->fetch(PDO::FETCH_ASSOC)['total'];

                            if (isset($total_despesas) & !empty($total_despesas)) {
                                $total_despesas_formatted = number_format($total_despesas, 2, ',', '.');
                            } else {
                                $total_despesas_formatted = "0,00";
                            }

                            $orcamento = "N/A";
                        ?>
                            <a href="../tarefas/index.php?id=<?= $tarefa['id'] ?>" class="list-group-item list-group-item-action" data-id="<?php echo $tarefa['id']; ?>">
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-1"><?= htmlspecialchars($tarefa['descricao']); ?></h5>
                                    <small class="text-muted">
                                        <span title="<?= $tarefa['descricao_status'] ?>" style="margin-top: 10px; color: #FFFFFF; background-color: <?= $tarefa['color'] ?>; width: 100px; text-align: center; display: inline-block; padding: 5px;" class="badge">Status: <?= $tarefa['titulo'] ?></span>
                                    </small>
                                </div>

                                <p class="mb-1">Orçamento: R$ <?= $total_despesas_formatted; ?></p>

                                <small class="text-muted">Criada em: <?= $createdDate; ?></small>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', (event) => {
                            let isReorderable = false; // Inicialmente, a reordenação está desativada
                            const taskList = document.getElementById('taskList');
                            const toggleOrderBtn = document.getElementById('toggleOrderBtn');
                            const quadroId = <?php echo $quadro_id; ?>;

                            // Inicializa SortableJS, desativado por padrão
                            let sortable = new Sortable(taskList, {
                                animation: 150,
                                handle: '.list-group-item',
                                disabled: true, // Inicialmente desativado
                                onEnd: function() {
                                    // Executa quando o reordenamento termina
                                    const order = [];
                                    taskList.querySelectorAll('.list-group-item').forEach((item) => {
                                        order.push(item.getAttribute('data-id'));
                                    });

                                    fetch('../processa/adicionar_mover_tarefa.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded',
                                            },
                                            body: new URLSearchParams({
                                                task_order: order.join(','),
                                                quadro_id: quadroId
                                            })
                                        })
                                        .then(response => response.text())
                                        .then(data => {
                                            console.log('Success:', data);
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                        });
                                }
                            });

                            // Adiciona um evento ao botão para alternar a reordenação
                            toggleOrderBtn.addEventListener('click', () => {
                                isReorderable = !isReorderable; // Alterna o estado de reordenação
                                sortable.option('disabled', !isReorderable); // Habilita ou desabilita o sortable

                                // Atualiza o texto e a cor do botão
                                toggleOrderBtn.textContent = isReorderable ? 'Travar' : 'Destravar';
                                toggleOrderBtn.classList.toggle('btn-danger', isReorderable);
                                toggleOrderBtn.classList.toggle('btn-primary', !isReorderable);
                            });
                        });
                    </script>
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