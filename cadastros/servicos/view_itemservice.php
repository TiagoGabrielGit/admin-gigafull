<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Obter o ID do submenu e do usuário
$submenu_id = "8";
$uid = $_SESSION['id'];

// Consulta para verificar permissões
$permissions = "
    SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = :uid AND pp.url_submenu = :submenu_id
";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions->bindParam(':submenu_id', $submenu_id, PDO::PARAM_STR);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
    $id = $_GET['id'];

    // Consulta para obter os dados do serviço
    $query_service = "
        SELECT item, integration_code, description, active
        FROM iten_service
        WHERE id = :id
    ";

    $exec_service = $pdo->prepare($query_service);
    $exec_service->bindParam(':id', $id, PDO::PARAM_INT);
    $exec_service->execute();

    $service = $exec_service->fetch(PDO::FETCH_ASSOC);

    if ($service) {
?>
        <style>
            /* CSS para mudar a cor de fundo da linha ao passar o mouse */
            .table-hover tbody tr:hover {
                background-color: #f5f5f5;
                cursor: pointer;
            }
        </style>
        <main id="main" class="main">
            <div class="row">
                <div class="col-10">
                    <div class="pagetitle">
                        <h1>Serviços</h1>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="processa/update_tem_service.php">
                            <br>
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="col-6">
                                        <label for="item" class="form-label">Item</label>
                                        <input class="form-control" id="item" name="item" value="<?= ($service['item']); ?>"></input>
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                    <div class="col-2">
                                        <label for="int_Code" class="form-label">Integration Code</label>
                                        <input class="form-control" id="int_Code" name="int_Code" value="<?= ($service['integration_code']); ?>"></input>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="col-12">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <input class="form-control" id="descricao" name="descricao" value="<?= ($service['description']); ?>"></input>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="col-6">
                                        <label for="ativo" class="form-label">Ativo</label>
                                        <select id="ativo" name="ativo" class="form-select">
                                            <option value="1" <?php if ($service['active'] == 1) echo 'selected'; ?>>Sim</option>
                                            <option value="0" <?php if ($service['active'] == 0) echo 'selected'; ?>>Não</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <div class="text-center">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Salvar Alterações</button>
                                <a href="/cadastros/servicos/itens_servicos.php">
                                    <button type="button" class="btn btn-secondary btn-sm">Voltar</button>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </main>
<?php
    } else {
        echo "Serviço não encontrado.";
    }
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>