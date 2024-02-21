<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];
$id = $_GET['id'];

$submenu_id = "53";

$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
    // Consulta SQL para obter os detalhes da máscara com base no ID fornecido
    $query_mascara = "SELECT tm.*, e.fantasia AS nome_empresa, tc.tipo AS tipo_chamado 
                      FROM tipos_chamados_mascaras tm
                      LEFT JOIN empresas e ON tm.empresa_id = e.id
                      LEFT JOIN tipos_chamados tc ON tm.tipo_chamado_id = tc.id
                      WHERE tm.id = :id";
    $stmt_mascara = $pdo->prepare($query_mascara);
    $stmt_mascara->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt_mascara->execute();
    $mascara = $stmt_mascara->fetch(PDO::FETCH_ASSOC);
?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Editar Máscara</h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <hr class="sidebar-divider">
                            <form method="POST" action="processa/editar_mascara.php">
                                <input readonly type="hidden" name="mascara_id" value="<?= $id ?>">
                                <div class="row">
                                    <div class="col-5">
                                        <label class="form-label" for="empresa">Empresa:</label>
                                        <input class="form-control" type="text" id="empresa" name="empresa" value="<?= $mascara['nome_empresa'] ?>" disabled>
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label" for="tipoChamado">Tipo de Chamado:</label>
                                        <input class="form-control" type="text" id="tipoChamado" name="tipoChamado" value="<?= $mascara['tipo_chamado'] ?>" disabled>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label" for="status">Status</label>
                                        <select id="status" name="status" class="form-select">
                                            <option value="1" <?= $mascara['active'] == '1' ? 'selected' : '' ?>>Ativo</option>
                                            <option value="0" <?= $mascara['active'] == '0' ? 'selected' : '' ?>>Inativo</option>
                                        </select>
                                    </div>

                                </div>
                                <br><br>
                                <div class="col-8">
                                    <label class="form-label" for="mascara">Máscara:</label>
                                    <textarea class="form-control" id="mascara" name="mascara" rows="15" cols="50"><?= $mascara['mascara'] ?></textarea>
                                </div>
                                <br><br>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-danger">Salvar Alterações</button>
                                    <a href="/servicedesk/tipos_chamados/mascaras/index.php"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>