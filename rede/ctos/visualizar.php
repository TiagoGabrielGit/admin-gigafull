<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "48";

$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    $id = $_GET['id'];
?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="text-left">
                            <h5 class="card-title">AFERIÇÕES REALIZADAS</h5>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href = '/rede/ctos/index.php';">Voltar</button>
                        </div>
                    </div>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Chamado</th>

                                <th style="text-align: center;">Solicitante</th>
                                <th style="text-align: center;">Empresa</th>
                                <th style="text-align: center;">Data</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_afericoes =
                                "SELECT a.id, p.nome, DATE_FORMAT(a.created, '%d/%m/%Y %H:%i') AS data_formatada, e.fantasia, a.chamado_id,

                                CASE
                                WHEN a.status = 1 THEN 'Em analise'
                                WHEN a.status = 2 THEN 'Negada'
                                WHEN a.status = 3 THEN 'Realizada'
                                END as status
                            FROM afericao as a
                            LEFT JOIN usuarios as u ON u.id = a.solicitante_id
                            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                            LEFT JOIN empresas as e ON u.empresa_id = e.id
                            WHERE a.cto_id = :id
                            ORDER BY a.chamado_id DESC";
                            $stmt_afericoes = $pdo->prepare($query_afericoes);
                            $stmt_afericoes->bindParam(':id', $id);
                            $stmt_afericoes->execute();
                            while ($afericao = $stmt_afericoes->fetch(PDO::FETCH_ASSOC)) :
                                $afericao_id = $afericao['id'];
                            ?>

                                <tr>
                                    <td style="text-align: center;"><?= $afericao['chamado_id']; ?></td>

                                    <td style="text-align: center;"><?= $afericao['nome']; ?></td>
                                    <td style="text-align: center;"><?= $afericao['fantasia']; ?></td>

                                    <td style="text-align: center;"><?= $afericao['data_formatada']; ?></td>
                                    <td style="text-align: center;"><?= $afericao['status']; ?></td>
                                    <td style="text-align: center;">
                                        <a href="/rede/afericao/afericao.php?id=<?= $afericao_id ?>"><button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#afericaoModal<?= $afericao_id ?>">
                                                Detalhes
                                            </button>
                                        </a>
                                    </td>
                                </tr>

                            <?php endwhile; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>