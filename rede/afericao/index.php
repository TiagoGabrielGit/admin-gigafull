<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$uid = $_SESSION['id'];
$submenu_id = "59";

$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {


?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>AFERIÇÕES</h1>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Filtro</h5>
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-3">
                            <label class="form-label" for="olt">OLT</label>
                            <select class="form-select" id="olt" name="olt">
                                <option value="">Todas as OLTs</option>
                                <?php
                                // Preenchendo o dropdown de OLTs dinamicamente
                                $busca_olts = "SELECT id, olt_name FROM gpon_olts WHERE active = 1 ORDER BY olt_name ASC";
                                $stmt_olts = $pdo->prepare($busca_olts);
                                $stmt_olts->execute();

                                // Mantendo a OLT selecionada
                                $filtro_olt_selecionada = $_GET['olt'] ?? '';

                                while ($olt = $stmt_olts->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($filtro_olt_selecionada == $olt['id']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($olt['id']) . "' $selected>" . htmlspecialchars($olt['olt_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="cto">CTO</label>
                            <input class="form-control" id="cto" name="cto" value="<?= htmlspecialchars($_GET['cto'] ?? '') ?>">
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="data_inicio">Data Início</label>
                            <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="<?= htmlspecialchars($_GET['data_inicio'] ?? '') ?>">
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="data_fim">Data Fim</label>
                            <input type="date" class="form-control" id="data_fim" name="data_fim" value="<?= htmlspecialchars($_GET['data_fim'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-sm btn-danger">Aplicar Filtros</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Listagem Aferições</h5>
                <style>
                    /* CSS para mudar a cor de fundo da linha ao passar o mouse */
                    .table-hover tbody tr:hover {
                        background-color: #f5f5f5; /* Escolha a cor que desejar */
                        cursor: pointer;
                    }
                </style>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Chamado</th>
                            <th scope="col">Solicitante</th>
                            <th scope="col">Atendente</th>
                            <th scope="col">OLT</th>
                            <th scope="col">CTO</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Capturando os valores dos filtros
                        $filtro_olt = $_GET['olt'] ?? '';
                        $filtro_cto = $_GET['cto'] ?? '';
                        $filtro_data_inicio = $_GET['data_inicio'] ?? '';
                        $filtro_data_fim = $_GET['data_fim'] ?? '';

                        // Construindo a consulta SQL com os filtros aplicados
                        $consulta_afericoes = 
                        "SELECT 
                                a.id as id_afericao,
                                a.chamado_id as chamado_id, 
                                p.nome as nome_solicitante, 
                                p2.nome as nome_atendente, 
                                e.fantasia as fantasia, 
                                gc.title as cto, 
                                go.olt_name as olt, 
                                a.created as data_criacao
                            FROM afericao as a
                            LEFT JOIN usuarios as u ON u.id = a.solicitante_id
                            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                            LEFT JOIN empresas as e ON a.empresa_id = e.id
                            LEFT JOIN gpon_ctos as gc ON gc.id = a.cto_id
                            LEFT JOIN gpon_olts as go ON go.id = a.olt_id
                            LEFT JOIN chamados as c ON c.id = a.chamado_id
                            LEFT JOIN usuarios as u2 ON u2.id = c.atendente_id
                            LEFT JOIN pessoas as p2 ON p2.id = u2.pessoa_id
                            WHERE 1=1";

                        // Adicionando condições de filtro
                        if ($filtro_olt) {
                            $consulta_afericoes .= " AND go.id = :olt";
                        }
                        if ($filtro_cto) {
                            $consulta_afericoes .= " AND gc.title LIKE :cto";
                        }
                        if ($filtro_data_inicio) {
                            $consulta_afericoes .= " AND a.created >= :data_inicio";
                        }
                        if ($filtro_data_fim) {
                            $consulta_afericoes .= " AND a.created <= :data_fim";
                        }

                        // Ordenação e limite
                        $consulta_afericoes .= " ORDER BY data_criacao DESC LIMIT 100";

                        try {
                            // Preparando a consulta
                            $stmt = $pdo->prepare($consulta_afericoes);

                            // Vinculando os parâmetros
                            if ($filtro_olt) {
                                $stmt->bindParam(':olt', $filtro_olt, PDO::PARAM_INT);
                            }
                            if ($filtro_cto) {
                                $cto_param = '%' . $filtro_cto . '%';
                                $stmt->bindParam(':cto', $cto_param, PDO::PARAM_STR);
                            }
                            if ($filtro_data_inicio) {
                                $stmt->bindParam(':data_inicio', $filtro_data_inicio, PDO::PARAM_STR);
                            }
                            if ($filtro_data_fim) {
                                $stmt->bindParam(':data_fim', $filtro_data_fim, PDO::PARAM_STR);
                            }

                            // Executando a consulta
                            $stmt->execute();

                            // Iterando sobre os resultados da consulta
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                // Formatando a data para um formato mais legível
                                $data_criacao = $row['data_criacao'] ? date("d/m/Y H:i:s", strtotime($row['data_criacao'])) : '';
                        ?>
                                <tr onclick="window.location.href='afericao.php?id=<?= htmlspecialchars($row['id_afericao']) ?>'">
                                    <!-- Exibindo os dados das aferições na tabela -->
                                    <td><?= htmlspecialchars($row['chamado_id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['nome_solicitante'] ?? '') ?> - (<?= htmlspecialchars($row['fantasia'] ?? '') ?>)</td>
                                    <td><?= htmlspecialchars($row['nome_atendente'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['olt'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['cto'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($data_criacao) ?></td>
                                </tr>
                        <?php
                            }
                        } catch (PDOException $e) {
                            // Exibindo mensagem de erro amigável ao usuário
                            echo "<tr><td colspan='6'>Erro ao carregar as aferições. Por favor, tente novamente mais tarde.</td></tr>";
                            // Registrando o erro para debug
                            error_log("Erro ao buscar aferições: " . $e->getMessage());
                        }
                        ?>
                    </tbody>
                </table>
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
