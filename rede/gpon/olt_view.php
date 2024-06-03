<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];
$submenu_id = "32";

$permissions =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON  u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    $idOlt = $_GET['id'];

    $sql_olt = "SELECT
            gpo.id as idOLT,
            gpo.olt_name as olt,
            gpo.active as active,
            eqp.hostname as equipamento,
            gpo.city as city,
            gpo.olt_username as intuser,
            gpo.olt_password as intpass,
            gpo.analisar_gpon as analisar_gpon,
            e.fabricante as fabricante_id
            FROM gpon_olts as gpo
            LEFT JOIN equipamentospop as eqp ON eqp.id = gpo.equipamento_id
            LEFT JOIN equipamentos as e ON e.id = eqp.equipamento_id
            LEFT JOIN fabricante as f ON f.id = e.fabricante
            WHERE gpo.id = :idOLT";

    try {
        // Prepara e executa a consulta usando prepared statements
        $stmt = $conn->prepare($sql_olt);
        $stmt->bindParam(':idOLT', $idOlt, PDO::PARAM_INT);
        $stmt->execute();

        // Obtém o resultado da consulta como um array associativo
        $olt = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }

?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <form action="processa/edita_olt.php" method="POST" class="row g-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">ID: <?= $idOlt ?></h5>

                            <div class="row">
                                <div class="col-lg-7">
                                    <input readonly hidden name="id" type="text" class="form-control" id="id" value="<?= $idOlt ?>">
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="equipamentoVinculado" class="form-label">Equipamento Vinculado</label>
                                            <input disabled name="equipamentoVinculado" type="text" class="form-control" id="equipamentoVinculado" value="<?= $olt['equipamento']; ?>" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="activeOLT" class="form-label">Status</label>
                                            <select class="form-select" id="activeOLT" name="activeOLT" required>
                                                <option value="" disabled selected>Selecione...</option>
                                                <option value="0" <?= ($olt['active'] == 0) ? 'selected' : ''; ?>>Inativo</option>
                                                <option value="1" <?= ($olt['active'] == 1) ? 'selected' : ''; ?>>Ativo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="oltName" class="form-label">Identificação</label>
                                            <input name="oltName" type="text" class="form-control" id="oltName" value="<?= $olt['olt']; ?>" required>
                                        </div>

                                        <div class="col-4">
                                            <label for="cidadeOLT" class="form-label">Cidade</label>
                                            <input name="cidadeOLT" type="text" class="form-control" id="cidadeOLT" value="<?= $olt['city']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-5">
                                            <label for="usuarioIntegracao" class="form-label">Usuário Integração</label>
                                            <input name="usuarioIntegracao" type="text" class="form-control" id="usuarioIntegracao" value="<?= $olt['intuser']; ?>">
                                        </div>

                                        <div class="col-4">
                                            <label for="senhaIntegracao" class="form-label">Senha Integração</label>
                                            <input name="senhaIntegracao" type="text" class="form-control" id="senhaIntegracao" value="<?= $olt['intpass']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <?php if ($olt['fabricante_id'] == 1) { ?>
                                        <div class="row mb-3">
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="analisar_gpon" <?= $olt['analisar_gpon'] ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="gridCheck1">
                                                        Integração OLT Analisar GPON
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row mb-3">
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input disabled class="form-check-input" type="checkbox" id="gridCheck1" name="analisar_gpon">
                                                    <label class="form-check-label" for="gridCheck1">
                                                        Integração OLT Analisar GPON (Não disponivel para esta OLT)
                                                    </label>
                                                </div>
                                            </div>
                                        </div> <?php } ?>
                                </div>
                            </div>
                            <hr class="sidebar-divider">
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                                    <a href="/rede/gpon/index.php" class="btn btn-sm btn-secondary">Voltar</a>
                                </div>
                                <div class="col-4">
                                    <a href="interessados.php?olt_id=<?= $idOlt ?>" class="btn btn-sm btn-info">Interessados</a>
                                    <a href="pons.php?olt_id=<?= $idOlt ?>" class="btn btn-sm btn-warning">PONs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>