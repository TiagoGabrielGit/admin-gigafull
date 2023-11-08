<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "44";

$permissions =
    "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM manutencao_programada_responsaveis_aceite WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $responsavel = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($responsavel) {
        $nome = $responsavel['nome'];
        $email = $responsavel['email'];
        $status = $responsavel['active']; // Adicione o campo status
    } else {
        header('Location: erro.php');
        exit;
    }
} else {
    header('Location: erro.php');
    exit;
}
?>

<main class="main" id="main">
    <div class="pagetitle">
        <h1>Editar Responsável</h1>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">

                <hr class="sidebar-divider">

                <form action="processa/atualizar_responsavel.php" method="post">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label" for="nome">Nome</label>
                            <input class="form-control" id="nome" name="nome" type="text" value="<?= $nome; ?>" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $email; ?>" required>
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1" <?= ($status == 1) ? 'selected' : ''; ?>>Ativo</option>
                                <option value="0" <?= ($status == 0) ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>
                    <hr class="sidebar-divider">
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-danger">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php"; ?>