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
    // Se o usuário tem permissão, carregamos a categoria
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Obtenção do ID da categoria via GET

    // Consulta para buscar a categoria
    $categoria_query = "SELECT * FROM qt_categorias WHERE id = :id";
    $stmt = $pdo->prepare($categoria_query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificação se a categoria foi encontrada
    if (!$categoria) {
        echo "Categoria não encontrada.";
        exit();
    }

?>
    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>Editar Categoria</h1>
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
                    <form method="POST" action="processa/atualizar_categoria.php">
                        <input type="hidden" id="id_categoria" name="id_categoria" value="<?= $id ?>">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="categoria">Categoria</label>
                                <input required class="form-control" id="categoria" name="categoria" value="<?php echo htmlspecialchars($categoria['descricao']); ?>">
                            </div>
                            <div class="col-3">
                                <label class="form-label" for="status">Status</label>
                                <select required class="form-select" id="status" name="status">
                                    <option value="1" <?php if ($categoria['active'] == 1) echo 'selected'; ?>>Ativo</option>
                                    <option value="0" <?php if ($categoria['active'] == 0) echo 'selected'; ?>>Inativo</option>
                                </select>
                            </div>
                            <div class="col-3">
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