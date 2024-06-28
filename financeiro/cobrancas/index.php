<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$empresa_id = $_SESSION['empresa_id'];
$uid = $_SESSION['id'];
$menu_id = "33";

$permissions =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
?>

    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="card-title">COBRANÇAS</h5>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th>Competência</th>
                                <th>Empresa</th>
                                <th>Contrato ID</th>
                                <th>Serviço</th>
                                <th>Valor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $busca_faturamentos =
                                "SELECT 
        cf.competencia as competencia,
        e.fantasia as fantasia,
        c.id as contrato_id,
        s.service as service,
        cf.valor as valor,
        CASE
        WHEN cf.status = 1 THEN 'Pendente'
        WHEN cf.status = 2 THEN 'Pago'
        END as status

        FROM contrato_faturamento as cf
        LEFT JOIN contract as c ON c.id = cf.contrato_id
        LEFT JOIN empresas as e ON e.id = c.empresa_id
        LEFT JOIN contract_service as cs ON cs.id = cf.servico_id
        LEFT JOIN service as s ON s.id = cs.service_id
        WHERE c.empresa_id = $empresa_id
        ORDER BY cf.competencia DESC, e.fantasia ASC";

                            $stmt = $pdo->prepare($busca_faturamentos);
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr style="vertical-align: middle; text-align: center;">
                                    <td><?php echo htmlspecialchars($row['competencia']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fantasia']); ?></td>
                                    <td><?php echo htmlspecialchars($row['contrato_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['service']); ?></td>
                                    <td><?php echo 'R$ ' . number_format($row['valor'], 2, ',', '.'); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

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