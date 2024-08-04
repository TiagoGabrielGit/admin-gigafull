<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "71";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";
$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
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
            <h1>AGRUPAMENTOS</h1>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10"></div>
                        <div class="col-lg-2">
                            <button style="margin-top: 15px;" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal_novo_agrupamento">Criar Novo</button>
                        </div>
                    </div>
                    <br>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr style="text-align: center;">
                                <th scope="col">Agrupamento</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta para buscar os agrupamentos
                            $sql = "SELECT agrupamento, active FROM cc_agrupamentos";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();

                            // Loop para preencher a tabela com os dados dos agrupamentos
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                // Determinar o status (1 = Ativo, 0 = Inativo)
                                $status = $row['active'] == 1 ? 'Ativo' : 'Inativo';
                                echo "<tr style='vertical-align: middle; text-align: center;'>";
                                echo "<td>" . htmlspecialchars($row['agrupamento']) . "</td>";
                                echo "<td>" . $status . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="modal_novo_agrupamento" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Agrupamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="processa/novo_agrupamento.php">
                        <div class="col-8">
                            <label class="form-label" for="agrupamento">Agrupamento</label>
                            <input required class="form-control" id="agrupamento" name="agrupamento">
                        </div>
                        <br><br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div><!-- End Large Modal-->

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>