<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


$submenu_id = "61";
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
?>

    <style>
        /* CSS para mudar a cor de fundo da linha ao passar o mouse */
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            /* Escolha a cor que desejar */
            cursor: pointer;
        }
    </style>
    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>STATUS DE TAREFAS</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['msg'])) { ?>
                        <br>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?= $_SESSION['msg'] ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['msg']);
                    } ?>



                    <h3 class="card-title">Adicionar Status</h3>
                    <form method="POST" action="processa/novo_status.php">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label" for="status">Status</label>
                                <input required class="form-control" id="status" name="status"></input>
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="tipo_fechamento">Tipo Fechamento <span class="bi bi-info-circle info-icon" data-bs-toggle="tooltip" title="Se marcado como sim, quando uma tarefa receber este status não podera mais ser editada."></span>
                                </label>
                                <select required class="form-select" id="tipo_fechamento" name="tipo_fechamento">
                                    <option selected disabled value="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <button style="margin-top: 33px;" type="submit" class="btn btn-sm btn-danger">Criar Novo Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Lista de Status</h3>

                    <!-- Tornando a tabela responsiva -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" scope="col">Status de Tarefas</th>
                                    <th style="text-align: center;" scope="col">Ativo</th>
                                    <th style="text-align: center;" scope="col">Default</th>
                                    <th style="text-align: center;" scope="col">Fechamento de Tarefa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Preparar a consulta SQL
                                $sql = "SELECT
                                ts.id as id_status, 
                                    ts.descricao as descricao,
                                    CASE
                                        WHEN ts.active = 1 THEN 'Ativado'
                                        WHEN ts.active = 0 THEN 'Inativo'
                                    END as active,
                                    CASE
                                        WHEN ts.default = 1 THEN 'Sim'
                                        WHEN ts.default = 0 THEN 'Não'
                                    END as default_status,
                                    CASE
                                        WHEN ts.status_fechamento = 1 THEN 'Sim'
                                        WHEN ts.status_fechamento = 0 THEN 'Não'
                                    END as status_fechamento
                                    FROM tarefas_status as ts";

                                try {
                                    // Executar a consulta
                                    $stmt = $pdo->query($sql);

                                    // Verificar se existem resultados
                                    if ($stmt->rowCount() > 0) {
                                        // Iterar sobre os resultados e criar linhas na tabela
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr onclick="window.location.href='view.php?id=<?= htmlspecialchars($row['id_status']) ?>'">


                                                <td style="text-align: center;"><?= htmlspecialchars($row['descricao']) ?></td>
                                                <td style="text-align: center;"><?= htmlspecialchars($row['active']) ?></td>
                                                <td style="text-align: center;"><?= htmlspecialchars($row['default_status']) ?></td>
                                                <td style="text-align: center;"><?= htmlspecialchars($row['status_fechamento']) ?></td>
                                            </tr>
                                <?php }
                                    } else {
                                        echo "<tr><td colspan='4' style='text-align: center;'>Nenhum status de tarefa encontrado.</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='4' style='text-align: center;'>Erro ao carregar dados: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
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