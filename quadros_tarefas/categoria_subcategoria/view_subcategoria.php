<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Verificação de permissões
$submenu_id = "62"; // ID do submenu específico
$uid = $_SESSION['id']; // ID do usuário logado

$permissions_query = "SELECT u.perfil_id
                      FROM usuarios u
                      JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
                      WHERE u.id = :uid AND pp.url_submenu = :submenu_id";

$exec_permissions = $pdo->prepare($permissions_query);
$exec_permissions->bindValue(':uid', $uid, PDO::PARAM_INT);
$exec_permissions->bindValue(':submenu_id', $submenu_id, PDO::PARAM_INT);
$exec_permissions->execute();

if ($exec_permissions->rowCount() > 0) {
    // Se o usuário tem permissão, carregamos a subcategoria
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Obtenção do ID da subcategoria via GET

    // Consulta para buscar a subcategoria e a categoria associada
    $subcategoria_query = "
    SELECT qs.id, qs.descricao AS subcategoria, qs.active, qc.descricao AS categoria, qc.id AS categoria_id
    FROM qt_subcategoria qs
    LEFT JOIN qt_categorias qc ON qc.id = qs.id_categoria
    WHERE qs.id = :id";
    $stmt = $pdo->prepare($subcategoria_query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $subcategoria = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificação se a subcategoria foi encontrada
    if (!$subcategoria) {
        echo "Subcategoria não encontrada.";
        exit();
    }

?>
    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>Editar Subcategoria</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <br>
                    <div class="row">
                        <div class="col-10"></div>
                        <div class="col-2">
                            <a href="/quadros_tarefas/categoria_subcategoria/index.php">
                                <button class="btn btn-sm btn-danger">Listagem de Categorias</button>
                            </a>
                        </div>
                    </div>
                    <?php
                    if (isset($_SESSION['msg'])) { ?>
                        <br>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?= $_SESSION['msg'] ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['msg']);
                    } ?>
                    <form method="POST" action="processa/atualizar_subcategoria.php">
                        <input type="hidden" id="id_subcategoria" name="id_subcategoria" value="<?= $id ?>">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label" for="categoria">Categoria</label>
                                <input required class="form-control" id="categoria" name="categoria" value="<?= htmlspecialchars($subcategoria['categoria']); ?>" readonly>
                            </div>
                            <div class="col-4">
                                <label class="form-label" for="subcategoria">Subcategoria</label>
                                <input required class="form-control" id="subcategoria" name="subcategoria" value="<?= htmlspecialchars($subcategoria['subcategoria']); ?>">
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="status">Status</label>
                                <select required class="form-select" id="status" name="status">
                                    <option value="1" <?= $subcategoria['active'] == 1 ? 'selected' : ''; ?>>Ativo</option>
                                    <option value="0" <?= $subcategoria['active'] == 0 ? 'selected' : ''; ?>>Inativo</option>
                                </select>
                            </div><br>
                            <div class="text-center">
                                <button style="margin-top: 32px;" class="btn btn-sm btn-danger" type="submit">Salvar Alterações</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    // Caso o usuário não tenha permissão
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>