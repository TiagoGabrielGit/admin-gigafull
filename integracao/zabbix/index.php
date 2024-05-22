<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

// Função para verificar permissões
function verificarPermissao($pdo, $uid, $submenu_id)
{
    $query = "
        SELECT u.perfil_id
        FROM usuarios u
        JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
        WHERE u.id = :uid AND pp.url_submenu = :submenu_id
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $stmt->bindParam(':submenu_id', $submenu_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}

$submenu_id = 31; // Usando número inteiro para $submenu_id
$uid = $_SESSION['id'];

if (verificarPermissao($pdo, $uid, $submenu_id)) {
    // Consulta para integração Zabbix
    $query = "
        SELECT
            iz.id as id,
            iz.tokenAPI as tokenAPI,
            iz.descricao as descricao,
            CASE
                WHEN iz.statusIntegracao = 1 THEN 'Ativado'
                WHEN iz.statusIntegracao = 0 THEN 'Inativado'
            END AS statusIntegracao,
            iz.urlZabbix as urlZabbix
        FROM integracao_zabbix as iz
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-10">
                                    <h5 class="card-title">Integração Zabbix</h5>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalNovoZabbix" style="margin-top: 15px;" class="btn btn-sm btn-danger">Criar Novo</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">ID</th>
                                                <th style="text-align: center;">Descrição</th>
                                                <th style="text-align: center;">Status da Integração</th>
                                                <th style="text-align: center;">URL do Zabbix</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($resultados)) : ?>
                                                <?php foreach ($resultados as $row) : ?>
                                                    <tr>
                                                        <td style="text-align: center;"><?= htmlspecialchars($row['id']); ?></td>
                                                        <td style="text-align: center;"><?= htmlspecialchars($row['descricao']); ?></td>
                                                        <td style="text-align: center;"><?= htmlspecialchars($row['statusIntegracao']); ?></td>
                                                        <td style="text-align: center;"><?= htmlspecialchars($row['urlZabbix']); ?></td>
                                                        <td><a href="view_zabbix.php?id=<?= $row['id'] ?>"><button class="btn btn-sm btn-danger">Editar</button></a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="4">Nenhum dado encontrado.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="modalNovoZabbix" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Cadastro Zabbix</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="processa/novo_cadastro.php" method="POST">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="descricaoZabbix" class="form-label">Descrição</label>
                                <input required name="descricaoZabbix" id="descricaoZabbix" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="tokenAPI" class="form-label">Token API Zabbix</label>
                                <input required name="tokenAPI" id="tokenAPI" class="form-control" type="text"></input>
                            </div>

                            <div class="col-6">
                                <label for="urlZabbix" class="form-label">URL Zabbix</label>
                                <input required placeholder="Ex: http://zabbix.dominio.com.br/api_jsonrpc.php" name="urlZabbix" id="urlZabbix" class="form-control" type="text">
                            </div>
                        </div>
                        <br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->
<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>