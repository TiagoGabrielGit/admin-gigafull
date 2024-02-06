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
?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="text-left">
                            <h5 class="card-title">CTOs</h5>
                        </div>
                    </div>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Caixa</th>
                                <th style="text-align: center;">Quantidade Aferições</th>
                                <th style="text-align: center;">Mais Informações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_ctos = "SELECT * FROM gpon_ctos";
                            $stmt = $pdo->query($query_ctos);
                            while ($caixas = $stmt->fetch(PDO::FETCH_ASSOC)) :
                                $id = $caixas['id'];
                            ?>

                                <tr>
                                    <td style="text-align: center;"><?= $id; ?></td>
                                    <td style="text-align: center;"><?= $caixas['title']; ?></td>

                                    <?php
                                    $quantidade_afericoes_query = "SELECT COALESCE(COUNT(*), 0) AS total_afericoes FROM afericao WHERE cto_id = :cto_id";
                                    $quantidade_afericoes = $pdo->prepare($quantidade_afericoes_query);
                                    $quantidade_afericoes->bindParam(':cto_id', $id);
                                    $quantidade_afericoes->execute();
                                    $total_afericoes = $quantidade_afericoes->fetchColumn();
                                    ?>

                                    <td style="text-align: center;"><?= $total_afericoes; ?></td>

                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href = 'visualizar.php?id=<?= $id ?>';">Visualizar</button>
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