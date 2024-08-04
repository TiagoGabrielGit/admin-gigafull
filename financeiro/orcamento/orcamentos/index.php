<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = 69;  // Assumindo que é um valor numérico
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = :uid AND pp.url_submenu = :submenu_id";
$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions_submenu->bindParam(':submenu_id', $submenu_id, PDO::PARAM_INT);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
?>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>ORÇAMENTOS</h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">

                <div class="row">
                    <div class="col-10"></div>
                    <div class="col-2">
                    <button style="margin-top: 15px;" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal_novo_orcamento">Novo Orçamento</button>
                    </div>
                </div>
                    <br>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr style="text-align: center;">
                                <th scope="col">Orçamento</th>
                                <th scope="col">Criado Por</th>
                                <th scope="col">Data Criação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Construir a consulta com base nos filtros
                            $sql = "SELECT o.id, o.orcamento, p.nome, o.created_date
                                    FROM cc_orcamento as o
                                    LEFT JOIN usuarios as u ON u.id = o.created_by
                                    LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                    WHERE o.created_by = :created_by
                                    ORDER BY orcamento ASC";

                            $stmt = $pdo->prepare($sql);

                            // Bind dos parâmetros
                            $stmt->bindParam(':created_by', $_SESSION['id'], PDO::PARAM_INT);

                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                                $created_date = new DateTime($row['created_date']);
                                ?>
                                <tr style='vertical-align: middle; text-align: center;' onclick="window.location.href='view.php?id=<?= $row['id'] ?>'">
                                    <td><?= htmlspecialchars($row['orcamento']) ?></td>
                                    <td><?= htmlspecialchars($row['nome']) ?></td>
                                    <td><?= $created_date->format('d/m/Y') ?></td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="modal_novo_orcamento" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Orçamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="processa/novo_orcamento.php">

                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="orcamento">Orçamento</label>
                                <input class="form-control" required id="orcamento" name="orcamento">
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-danger">Criar Orçamento</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>
