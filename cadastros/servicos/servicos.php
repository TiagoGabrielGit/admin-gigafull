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
?>
    <style>
        /* CSS para mudar a cor de fundo da linha ao passar o mouse */
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Serviços</h1>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a href="servicos.php"><button class="nav-link active">Serviços</button></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="itens_servicos.php"><button class="nav-link" type="button">Itens de Serviço</button></a>
                                            </li>
                                        </ul>

                                        <div class="row">
                                            <div class="col-10">
                                                <h5 class="card-title">Serviços cadastrados</h5>
                                            </div>

                                            <div class="col-2">
                                                <div class="card">
                                                    <button style="margin-top: 15px" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoServico">
                                                        Novo Serviço
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Tabela com linhas listradas -->
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr style="text-align: center;">
                                                        <th scope="col">Código Serviço</th>
                                                        <th scope="col">Serviço</th>
                                                        <th scope="col">Descrição</th>
                                                        <th scope="col">Item de Serviço</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Consulta para obter os serviços
                                                    $sql_view_servicos = "
                                                        SELECT
                                                            s.id as idServico,
                                                            s.service as service,
                                                            s.description as descricao,
                                                            s.item_service as item_service,
                                                            CASE
                                                                WHEN s.item_service = '1' THEN 'Sim'
                                                                WHEN s.item_service = '0' THEN 'Não'
                                                            END as item,
                                                            CASE
                                                                WHEN s.active = '1' THEN 'Ativo'
                                                                WHEN s.active = '0' THEN 'Inativo'
                                                            END as active
                                                        FROM
                                                            service as s
                                                    ";

                                                    $stmt_servicos = $pdo->prepare($sql_view_servicos);
                                                    $stmt_servicos->execute();

                                                    while ($campos_servico = $stmt_servicos->fetch(PDO::FETCH_ASSOC)) {
                                                        $idServico = $campos_servico['idServico']; ?>
                                                        <tr style="vertical-align: middle; text-align: center;" onclick="window.location.href='view_service.php?id=<?= $campos_servico['idServico'] ?>'">
                                                            <td><?= $idServico ?></td>
                                                            <td><?= $campos_servico['service']; ?></td>
                                                            <td><?= $campos_servico['descricao']; ?></td>
                                                            <td><?= $campos_servico['item']; ?></td>
                                                            <td><?= $campos_servico['active']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <!-- Fim da tabela com linhas listradas -->
                                        </div>

                                        <div class="modal fade" id="modalNovoServico" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Novo Serviço</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <form action="processa/adicionar_servico.php" method="POST" class="row g-3">
                                                                <span id="msgCadastro"></span>

                                                                <div class="col-6">
                                                                    <label for="servico" class="form-label">Serviço</label>
                                                                    <input type="text" class="form-control" id="servico" name="servico" required>
                                                                </div>

                                                                <div class="col-3"></div>
                                                                <div class="col-3">
                                                                    <label for="item_service" class="form-label">Item de Serviço</label>
                                                                    <select id="item_service" name="item_service" class="form-select" required>
                                                                        <option selected disabled value="">Selecione</option>
                                                                        <option value='1'> Sim</option>
                                                                        <option value='0'> Não</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label for="descricao" class="form-label">Descrição</label>
                                                                    <textarea id="descricao" name="descricao" class="form-control" maxlength="100" required></textarea>
                                                                </div>

                                                                <hr class="sidebar-divider">

                                                                <div class="text-center">
                                                                    <button type="submit" class="btn btn-sm btn-danger">Criar Novo Serviço</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>