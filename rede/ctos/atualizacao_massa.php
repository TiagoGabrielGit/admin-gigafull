<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "48";

// Verificação de permissões
$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = :uid AND pp.url_submenu = :submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions->bindParam(':submenu_id', $submenu_id, PDO::PARAM_INT);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
    // Processar filtros
    $caixa = isset($_GET['caixa']) ? $_GET['caixa'] : '';
    $codigoIntegracao = isset($_GET['codigoIntegracao']) ? $_GET['codigoIntegracao'] : '';
    $filtroCodigoIntegracao = isset($_GET['filtroCodigoIntegracao']) ? $_GET['filtroCodigoIntegracao'] : 'todos';

?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="text-left">
                            <h5 class="card-title">FILTRO</h5>
                            <form method="GET" action="">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="caixa" class="form-label">Caixa</label>
                                        <input id="caixa" name="caixa" class="form-control" value="<?= htmlspecialchars($caixa) ?>"></input>
                                    </div>
                                    <div class="col-3">
                                        <label for="codigoIntegracao" class="form-label">Código Integração</label>
                                        <input id="codigoIntegracao" name="codigoIntegracao" class="form-control" value="<?= htmlspecialchars($codigoIntegracao) ?>"></input>
                                    </div>
                                    <div class="col-3">
                                        <label>&nbsp;</label>
                                        <select id="filtroCodigoIntegracao" name="filtroCodigoIntegracao" style="margin-top: 7px;" class="form-select">
                                            <option value="todos" <?= isset($_GET['filtroCodigoIntegracao']) && $_GET['filtroCodigoIntegracao'] == 'todos' ? 'selected' : '' ?>>Todos</option>
                                            <option value="comCodigo" <?= isset($_GET['filtroCodigoIntegracao']) && $_GET['filtroCodigoIntegracao'] == 'comCodigo' ? 'selected' : '' ?>>Com código integração</option>
                                            <option value="semCodigo" <?= isset($_GET['filtroCodigoIntegracao']) && $_GET['filtroCodigoIntegracao'] == 'semCodigo' ? 'selected' : '' ?>>Sem código integração</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label>&nbsp;</label>
                                        <button style="margin-top: 8px;" type="submit" class="btn btn-danger btn-sm form-control">Filtrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <h5 class="card-title">CTOs</h5>
                        </div>
                    </div>

                    <form method="POST" action="processa/process_update.php">
                        <table class="table table-striped">
                            <thead>
                                <th style="text-align: center;">Caixa</th>
                                <th style="text-align: center;">NB Integration</th>
                                <th style="text-align: center; width: 200px;">Código Integração</th>
                            </thead>
                            <tbody>
                                <?php
                                $query_ctos = "SELECT * FROM gpon_ctos WHERE 1=1";
                                if (!empty($caixa)) {
                                    $query_ctos .= " AND title LIKE :caixa";
                                }
                                if (!empty($codigoIntegracao)) {
                                    $query_ctos .= " AND paintegration_code LIKE :codigoIntegracao";
                                }

                                if ($filtroCodigoIntegracao == 'comCodigo') {
                                    $query_ctos .= " AND paintegration_code IS NOT NULL AND paintegration_code != ''";
                                } elseif ($filtroCodigoIntegracao == 'semCodigo') {
                                    $query_ctos .= " AND (paintegration_code IS NULL OR paintegration_code = '')";
                                }

                                $query_ctos .= " LIMIT 100";

                                $stmt = $pdo->prepare($query_ctos);
                                if (!empty($caixa)) {
                                    $caixa = "$caixa%";
                                    $stmt->bindParam(':caixa', $caixa, PDO::PARAM_STR);
                                }
                                if (!empty($codigoIntegracao)) {
                                    $codigoIntegracao = "$codigoIntegracao%";
                                    $stmt->bindParam(':codigoIntegracao', $codigoIntegracao, PDO::PARAM_STR);
                                }
                                $stmt->execute();

                                if ($stmt->rowCount() > 0) {
                                    while ($caixas = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <tr>
                                            <td style="text-align: center;"><?= htmlspecialchars($caixas['title']) ?></td>
                                            <td style="text-align: center;">
                                                <?= htmlspecialchars($caixas['nbintegration_code']) !== null ? htmlspecialchars($caixas['nbintegration_code']) : '' ?>
                                            </td>
                                            <td style="text-align: center; width: 200px;">
                                                <input type="hidden" name="ids[]" value="<?= $caixas['id'] ?>">
                                                <input style="text-align: center;" class="form-control" name="codigoIntegracao[<?= $caixas['id'] ?>]" value="<?= $caixas['paintegration_code'] !== null ? $caixas['paintegration_code'] : '' ?>">
                                            </td>
                                        </tr>
                                <?php }
                                } else {
                                    echo "<tr><td colspan='3' style='text-align: center;'>Não foram encontrados incidentes ativos.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
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