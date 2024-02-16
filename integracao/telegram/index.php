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
?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <div class="text-left">
                                    <h5 class="card-title">Parâmetros Integração Telegram</h5>
                                </div>
                            </div>

                            <!-- Default Tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Tokens</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Parametrização</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <hr class="sidebar-divider">

                                            <form action="processa/novo.php" method="POST">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="descricaoToken" class="form-label">Descrição</label>
                                                        <input class="form-control" id="descricaoToken" name="descricaoToken"></input>
                                                    </div>
                                                    <div class="col-5">
                                                        <label for="tokenTelegram" class="form-label">Token Telegram</label>
                                                        <input class="form-control" id="tokenTelegram" name="tokenTelegram"></input>
                                                    </div>

                                                </div>
                                                <br>
                                                <div class="text-center">
                                                    <button class="btn btn-sm btn-danger" type="submit">Criar Token</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <hr class="sidebar-divider">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Descricao</th>
                                                        <th>Token</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Consulta para obter os tokens
                                                    $integracao_telegram_query = "SELECT id, descricao, token, active FROM integracao_telegram";
                                                    $integracao_telegram_stmt = $pdo->query($integracao_telegram_query);
                                                    while ($integracao_telegram_row = $integracao_telegram_stmt->fetch(PDO::FETCH_ASSOC)) {
                                                        echo "<tr>";
                                                        echo "<td>" . $integracao_telegram_row['id'] . "</td>";
                                                        echo "<td>" . $integracao_telegram_row['descricao'] . "</td>";
                                                        echo "<td>" . $integracao_telegram_row['token'] . "</td>";
                                                        echo "<td>" . ($integracao_telegram_row['active'] == 1 ? 'Ativo' : 'Inativo') . "</td>";
                                                        echo "<td><a href='editar.php?id=" . $integracao_telegram_row['id'] . "' class='btn btn-danger btn-sm'>Editar</a></td>"; // Link para a página de edição com o ID do registro

                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <hr class="sidebar-divider">

                                            <form method="POST" action="processa/parametrizacao.php">
                                                <?php
                                                // Consulta para obter dados da notificação de abertura de chamado
                                                $query_abertura_chamado = "SELECT * FROM notificacao_telegram WHERE notificacao_id = 1";
                                                $stmt_abertura_chamado = $pdo->query($query_abertura_chamado);
                                                $row_abertura_chamado = $stmt_abertura_chamado->fetch(PDO::FETCH_ASSOC);
                                                $token_id_abertura_chamado = $row_abertura_chamado['token_id'];
                                                $active_abertura_chamado = $row_abertura_chamado['active'];
                                                ?>

                                                <div class="row mb-5">
                                                    <div class="col-sm-3">
                                                        <label style="margin-top: 10px;" class="form-label">(1) Envio de notificação de abertura de chamado</label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <select id="notificacaoAberturaChamado" name="notificacaoAberturaChamado" class="form-select">
                                                            <option value="">Selecione o token</option>
                                                            <?php
                                                            // Preparar e executar a consulta para obter os tokens ativos
                                                            $sql_abertura_chamado = "SELECT id, descricao FROM integracao_telegram WHERE active = 1";
                                                            $stmt_abertura_chamado = $pdo->query($sql_abertura_chamado);

                                                            // Verificar se a consulta foi bem sucedida
                                                            if ($stmt_abertura_chamado) {
                                                                // Loop através dos resultados e preencher as opções do select
                                                                while ($row_abertura_chamado = $stmt_abertura_chamado->fetch(PDO::FETCH_ASSOC)) {
                                                                    // Verificar se a opção deve ser pré-selecionada
                                                                    $selected_abertura_chamado = ($row_abertura_chamado["id"] == $token_id_abertura_chamado) ? "selected" : "";
                                                                    echo "<option value='" . $row_abertura_chamado["id"] . "' $selected_abertura_chamado>" . $row_abertura_chamado["descricao"] . "</option>";
                                                                }
                                                            } else {
                                                                echo "Erro ao executar a consulta.";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <select name="status" class="form-select">
                                                            <option value="1" <?php if ($active_abertura_chamado == 1) echo 'selected'; ?>>Ativo</option>
                                                            <option value="0" <?php if ($active_abertura_chamado == 0) echo 'selected'; ?>>Inativo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i></button>
                                                    </div>
                                                </div>
                                            </form>

                                            <form method="POST" action="processa/parametrizacao.php">
                                                <?php
                                                // Consulta para obter dados da notificação de relato de chamado
                                                $query_relato_chamado = "SELECT * FROM notificacao_telegram WHERE notificacao_id = 3";
                                                $stmt_relato_chamado = $pdo->query($query_relato_chamado);
                                                $row_relato_chamado = $stmt_relato_chamado->fetch(PDO::FETCH_ASSOC);
                                                $token_id_relato_chamado = $row_relato_chamado['token_id'];
                                                $active_relato_chamado = $row_relato_chamado['active'];
                                                ?>
                                                <div class="row mb-5">
                                                    <div class="col-sm-3">
                                                        <label style="margin-top: 10px;" class="form-label">(3) Envio de notificação de relato de chamado</label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <select id="notificacaoRelatoChamado" name="notificacaoRelatoChamado" class="form-select">
                                                            <option value="">Selecione o token</option>
                                                            <?php
                                                            // Preparar e executar a consulta para obter os tokens ativos
                                                            $sql_relato_chamado = "SELECT id, descricao FROM integracao_telegram WHERE active = 1";
                                                            $stmt_relato_chamado = $pdo->query($sql_relato_chamado);

                                                            // Verificar se a consulta foi bem sucedida
                                                            if ($stmt_relato_chamado) {
                                                                // Loop através dos resultados e preencher as opções do select
                                                                while ($row_relato_chamado = $stmt_relato_chamado->fetch(PDO::FETCH_ASSOC)) {
                                                                    // Verificar se a opção deve ser pré-selecionada
                                                                    $selected_relato_chamado = ($row_relato_chamado["id"] == $token_id_relato_chamado) ? "selected" : "";
                                                                    echo "<option value='" . $row_relato_chamado["id"] . "' $selected_relato_chamado>" . $row_relato_chamado["descricao"] . "</option>";
                                                                }
                                                            } else {
                                                                echo "Erro ao executar a consulta.";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <select name="status" class="form-select">
                                                            <option value="1" <?php if ($active_relato_chamado == 1) echo 'selected'; ?>>Ativo</option>
                                                            <option value="0" <?php if ($active_relato_chamado == 0) echo 'selected'; ?>>Inativo</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i></button>
                                                    </div>
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
        </section>
    </main>

<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>