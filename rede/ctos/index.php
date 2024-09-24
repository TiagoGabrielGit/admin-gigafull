<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "48";

// Verificação de permissões
$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = :uid AND pp.url_submenu = :submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions->bindParam(':submenu_id', $submenu_id, PDO::PARAM_INT);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
    // Processar filtros
    $caixa = isset($_GET['caixa']) ? $_GET['caixa'] : '';
    $empresa_id = isset($_GET['empresa_id']) ? $_GET['empresa_id'] : '';
    $limiteBusca = isset($_GET['limiteBusca']) ? $_GET['limiteBusca'] : '100';
    $codigoIntegracao = isset($_GET['codigoIntegracao']) ? $_GET['codigoIntegracao'] : '';
    $nbintegration = isset($_GET['nbintegration']) ? $_GET['nbintegration'] : '';

    // Buscar empresas
    $query_empresas = "SELECT id, fantasia FROM empresas WHERE deleted = 1 ORDER BY fantasia ASC";
    $stmt_empresas = $pdo->prepare($query_empresas);
    $stmt_empresas->execute();
    $empresas = $stmt_empresas->fetchAll(PDO::FETCH_ASSOC);
?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="text-left">
                            <h5 class="card-title">FILTRO</h5>
                            <form method="GET" action="">
                                <div class="row">
                                    <div class="row">

                                        <div class="col-3">
                                            <label for="empresa" class="form-label">Empresa</label>
                                            <select id="empresa" name="empresa_id" class="form-select">
                                                <option value="">Todas as Empresas</option>
                                                <?php foreach ($empresas as $empresaItem): ?>
                                                    <option value="<?= $empresaItem['id']; ?>" <?= $empresa_id == $empresaItem['id'] ? 'selected' : '' ?>>
    <?= $empresaItem['fantasia']; ?>
</option>

                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-3">
                                            <label for="caixa" class="form-label">Caixa</label>
                                            <input id="caixa" name="caixa" class="form-control" value="<?= htmlspecialchars($caixa) ?>"></input>
                                        </div>
                                        <div class="col-4">
                                            <label for="nbintegration" class="form-label">NB Integration</label>
                                            <input id="nbintegration" name="nbintegration" class="form-control" value="<?= htmlspecialchars($nbintegration) ?>"></input>
                                        </div>
                                        <div class="col-3">
                                            <label for="codigoIntegracao" class="form-label">Código Integração</label>
                                            <input id="codigoIntegracao" name="codigoIntegracao" class="form-control" value="<?= htmlspecialchars($codigoIntegracao) ?>"></input>
                                        </div>
                                        <div class="col-2">
                                            <label for="limiteBusca" class="form-label">Limite de Busca</label>
                                            <select id="limiteBusca" name="limiteBusca" class="form-select">
                                                <option value="10" <?= $limiteBusca == '10' ? 'selected' : '' ?>>10</option>
                                                <option value="50" <?= $limiteBusca == '50' ? 'selected' : '' ?>>50</option>
                                                <option value="100" <?= $limiteBusca == '100' ? 'selected' : '' ?>>100</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <label>&nbsp;</label>
                                            <button type="submit" class="btn btn-danger btn-sm form-control">Filtrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <h5 class="card-title">CTOs</h5>
                        </div>
                        <div class="col-lg-5">
                            <div class="col-12">
                                <button data-bs-toggle="modal" data-bs-target="#cadastrarCTO" style="margin-top: 15px;" class="btn btn-sm btn-danger">Cadastrar CTO</button>
                                <button style="margin-top: 15px;" type="button" class="btn btn-sm btn-warning" onclick="importarOZMAP()">Importar via OZMap</button>
                                <a href="atualizacao_massa.php"><button style="margin-top: 15px;" type="button" class="btn btn-sm btn-info">Atualização em Massa</button></a>
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Empresa</th>
                                <th style="text-align: center;">Caixa</th>
                                <th style="text-align: center;">OLT - SLOT/PON</th>
                                <th style="text-align: center;">NB Integration</th>
                                <th style="text-align: center;">Código Integração</th>
                                <th style="text-align: center;">Quantidade Aferições</th>
                                <th style="text-align: center;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Montar query com filtros
                            $query_ctos = 
                            "SELECT e.fantasia, gc.id, gc.title, gc.nbintegration_code, gc.paintegration_code, gc.lat, gc.lng, gp.slot, gp.pon, go.olt_name as olt
                            FROM gpon_ctos as gc
                            LEFT JOIN empresas as e ON e.id = gc.empresa_id
                            LEFT JOIN gpon_pon as gp ON gp.cod_int = gc.paintegration_code
                            LEFT JOIN gpon_olts as go ON go.id = gp.olt_id
                            WHERE 1=1";
                            if (!empty($empresa_id)) {
                                $query_ctos .= " AND gc.empresa_id LIKE :empresa_id";
                            }
                            if (!empty($caixa)) {
                                $query_ctos .= " AND gc.title LIKE :caixa";
                            }
                            if (!empty($nbintegration)) {
                                $query_ctos .= " AND gc.nbintegration_code LIKE :nbintegration_code";
                            }
                            if (!empty($codigoIntegracao)) {
                                $query_ctos .= " AND gc.paintegration_code LIKE :codigoIntegracao";
                            }
                            $query_ctos .= " LIMIT :limiteBusca";

                            $stmt = $pdo->prepare($query_ctos);
                            if (!empty($empresa_id)) {
                                $stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
                            }
                            
                            if (!empty($caixa)) {
                                $caixa = "%$caixa%";
                                $stmt->bindParam(':caixa', $caixa, PDO::PARAM_STR);
                            }
                            if (!empty($nbintegration)) {
                                $stmt->bindParam(':nbintegration_code', $nbintegration, PDO::PARAM_STR);
                            }
                            if (!empty($codigoIntegracao)) {
                                $codigoIntegracao = "$codigoIntegracao%";
                                $stmt->bindParam(':codigoIntegracao', $codigoIntegracao, PDO::PARAM_STR);
                            }
                            $stmt->bindParam(':limiteBusca', $limiteBusca, PDO::PARAM_INT);
                            $stmt->execute();

                            while ($caixas = $stmt->fetch(PDO::FETCH_ASSOC)) :
                                $id = $caixas['id'];
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?= $id; ?></td>
                                    <td style="text-align: center;"><?= $caixas['fantasia']; ?></td>

                                    <td style="text-align: center;"><?= $caixas['title']; ?></td>
                                    <td style="text-align: center;"><?= $caixas['olt'] . ' - ' . $caixas['slot'] . '/' . $caixas['pon'] ?></td>

                                    <td style="text-align: center;"><?= $caixas['nbintegration_code']; ?></td>
                                    <td style="text-align: center;"><?= $caixas['paintegration_code']; ?></td>

                                    <?php
                                    $quantidade_afericoes_query = "SELECT COALESCE(COUNT(*), 0) AS total_afericoes FROM afericao WHERE cto_id = :cto_id";
                                    $quantidade_afericoes = $pdo->prepare($quantidade_afericoes_query);
                                    $quantidade_afericoes->bindParam(':cto_id', $id, PDO::PARAM_INT);
                                    $quantidade_afericoes->execute();
                                    $total_afericoes = $quantidade_afericoes->fetchColumn();
                                    ?>

                                    <td style="text-align: center;"><?= $total_afericoes; ?></td>

                                    <td style="text-align: center;">
                                        <button title="Visualizar CTO" type="button" class="btn btn-sm btn-info" onclick="window.location.href = 'visualizar_cto.php?id=<?= $id ?>';">
                                            <i class="bi bi-arrow-right-square"></i>
                                        </button>

                                        <button title="Aferições CTO" type="button" class="btn btn-sm btn-warning" onclick="window.location.href = 'visualizar.php?id=<?= $id ?>';">
                                            <i class="bi bi-bezier"></i>
                                        </button>

                                        <button title="Localização da CTO" type="button" class="btn btn-sm btn-success" onclick="openLocation(<?= $caixas['lat'] ?>, <?= $caixas['lng'] ?>)">
                                            <i class="bi bi-pin-map"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="cadastrarCTO" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar CTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="processa/cadastrar_cto.php">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <label for="titulo" class="form-label">Titulo</label>
                                <input required id="titulo" name="titulo" class="form-control"></input>
                            </div>
                            <div class="col-3">
                                <label for="codigoIntegracao" class="form-label">Código Integração</label>
                                <input required id="codigoIntegracao" name="codigoIntegracao" class="form-control"></input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input required id="latitude" name="latitude" class="form-control"></input>
                            </div>
                            <div class="col-6">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input required id="longitude" name="longitude" class="form-control"></input>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Large Modal-->

    <div class="modal fade" id="importProgressModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Importação OZMap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="importProgressMessage">Realizando a importação...</div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button> -->
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script>
        function importarOZMAP() {
            // Abrir a modal de progresso
            var importProgressModal = new bootstrap.Modal(document.getElementById('importProgressModal'), {
                keyboard: false,
                backdrop: 'static'
            });
            importProgressModal.show();

            // Atualizar a mensagem de progresso
            function updateProgress(message) {
                document.getElementById('importProgressMessage').innerText = message;
            }

            updateProgress('Realizando importação, aguarde...');

            fetch('processa/importar_ozmap2.php')
                .then(response => {
                    console.log('Response status:', response.status);
                    if (response.status >= 200 && response.status < 300) {
                        return response.json();
                    } else {
                        throw new Error('Erro ao solicitar a importação.');
                    }
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        updateProgress('Importação concluída com sucesso. Atualizando a página...');
                        setTimeout(() => {
                            //alert('Retorno: ' + data.message);
                            location.reload();
                        }, 2000);
                    } else {
                        updateProgress('Erro: ' + data.message);
                        setTimeout(() => {
                            alert('Retorno: ' + data.message);
                        }, 4000);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    updateProgress('Erro ao atualizar CTOs: ' + error.message);
                    setTimeout(() => {
                        alert('Erro ao atualizar CTOs');
                    }, 2000);
                });
        }
    </script>

    <script>
        function openLocation(latitude, longitude) {
            const googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
            window.open(googleMapsUrl, '_blank');
        }
    </script>


<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>