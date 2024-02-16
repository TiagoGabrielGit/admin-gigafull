<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "51";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON  u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    // Verifique se o ID do token foi fornecido na URL
    if (isset($_GET['id'])) {
        // Prepare a consulta para obter os detalhes do token
        $id_token = $_GET['id'];
        $integracao_telegram = "SELECT * FROM integracao_telegram WHERE id = :id";
        $stmt = $pdo->prepare($integracao_telegram);
        $stmt->bindParam(':id', $id_token);
        $stmt->execute();
        $token = $stmt->fetch(PDO::FETCH_ASSOC);
    }

?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="text-left">
                                    <h5 class="card-title">Edição Token Telegram</h5>
                                </div>
                            </div>

                            <form method="POST" action="processa/editar.php">
                                <input hidden readonly id="id" name="id" value="<?= $id_token ?>">

                                <div class="row">
                                    <div class="col-4">
                                        <label class="form-label" for="descricao">Descrição</label>
                                        <input class="form-control" id="descricao" name="descricao" value="<?php echo $token['descricao']; ?>"></input>
                                    </div>

                                    <div class="col-5">
                                        <label class="form-label" for="token">Token</label>
                                        <input class="form-control" id="token" name="token" value="<?php echo $token['token']; ?>"></input>
                                    </div>

                                    <div class="col-3">
                                        <label class="form-label" for="status">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="1" <?php if ($token['active'] == 1) echo 'selected'; ?>>Ativado</option>
                                            <option value="0" <?php if ($token['active'] == 0) echo 'selected'; ?>>Inativo</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="text-center">
                                    <button class="btn btn-sm btn-danger" type="submit">Aplicar Alterações</button>
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
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>