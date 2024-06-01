<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "22";
$uid = $_SESSION['id'];

// Verificar permissões do usuário para o submenu
$permissions_submenu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = :uid AND pp.url_submenu = :submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions_submenu->bindParam(':submenu_id', $submenu_id, PDO::PARAM_INT);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    $dados_usuario =
        "SELECT
            u.empresa_id as empresaID,
            e.atributoEmpresaPropria as atributoEmpresaPropria,
            oze.usuario_oz as usuario_oz
        FROM usuarios as u
        LEFT JOIN empresas as e ON e.id = u.empresa_id
        LEFT JOIN redeneutra_parceiro as rnp ON rnp.empresa_id = u.empresa_id
        LEFT JOIN integracao_ozmap_empresas AS oze ON oze.empresa_id = e.id
        WHERE u.id = :uid";

    $stmt_dados_usuario = $pdo->prepare($dados_usuario);
    $stmt_dados_usuario->bindParam(':uid', $uid, PDO::PARAM_INT);
    $stmt_dados_usuario->execute();
    $c_dados_usuario = $stmt_dados_usuario->fetch(PDO::FETCH_ASSOC);

    $empresaID = $c_dados_usuario['empresaID'];
    $empresaPropria = $c_dados_usuario['atributoEmpresaPropria'];
    $id_incidente = $_GET['id_incidente'];
    $usuario_oz = $c_dados_usuario['usuario_oz'];
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    $incidentes_ctos =
                        "SELECT gc.title as title, gc.nbintegration_code as nbintegration_code 
                        FROM incidentes_ctos as ic 
                        LEFT JOIN gpon_ctos as gc ON ic.cto_id = gc.id
                        WHERE incidente_id = :incidente_id";

                    $stmt = $pdo->prepare($incidentes_ctos);
                    $stmt->bindParam(':incidente_id', $id_incidente, PDO::PARAM_INT);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        // Consulta à tabela integracao_ozmap para obter a URL da API e a chave de autenticação
                        $queryIntegracaoOzmap = "SELECT urlAPI, chaveAutenticacao FROM integracao_ozmap LIMIT 1";
                        $stmtIntegracaoOzmap = $pdo->query($queryIntegracaoOzmap);
                        $integracaoOzmap = $stmtIntegracaoOzmap->fetch(PDO::FETCH_ASSOC);

                        if (empty($integracaoOzmap['urlAPI']) || empty($integracaoOzmap['chaveAutenticacao'])) { ?>

                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12">
                                        <h5 style="text-align: center; margin-top: 30px;" class="card-title">Integração com OZMap não configurada.</h5>
                                    </div>
                                </div>
                            </div>
                            <?php } else {
                            $urlAPI = $integracaoOzmap['urlAPI'];
                            $chaveAutenticacao = $integracaoOzmap['chaveAutenticacao'];

                            while ($rowCTOs = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                $APIurl = $urlAPI . '/properties?filter=[{"property":"box","value":"' . $rowCTOs['nbintegration_code'] . '","operator":"eq"}]';

                                // Configurações cURL
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $APIurl);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                    "Authorization: Bearer $chaveAutenticacao"
                                ]);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                $response = curl_exec($ch);
                                if ($response === false) {
                                    echo "Erro ao acessar a API: " . curl_error($ch);
                                } else {
                                    $data = json_decode($response, true);

                                    if ($data !== null && isset($data['rows'])) {
                                        $clients = [];
                                        foreach ($data['rows'] as $row) {
                                            if (isset($row['client']['code']) && isset($row['client']['name'])) {
                                                $client = [
                                                    'code' => $row['client']['code'],
                                                    'name' => $row['client']['name']
                                                ];
                                                if (isset($row['client']['creatorData']['username'])) {
                                                    $client['username'] = $row['client']['creatorData']['username'];
                                                } else {
                                                    $client['username'] = "";
                                                }
                                                $clients[] = $client;
                                            }
                                        }
                            ?>

                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">CTO: <?= htmlspecialchars($rowCTOs['title']) ?></h5>
                                                <?php
                                                $contador = 0;

                                                foreach ($clients as $client) {
                                                    if ($empresaPropria == 1) {
                                                        $contador++; ?>
                                                        <span><?= htmlspecialchars($client['code']) . ' - ' . htmlspecialchars($client['name']) ?></span><br>
                                                    <?php
                                                    } else if (!empty($client['username']) && ($usuario_oz == $client['username'])) {
                                                        $contador++;

                                                    ?>
                                                        <span><?= htmlspecialchars($client['code']) . ' - ' . htmlspecialchars($client['name']) ?></span><br>
                                                    <?php }
                                                }
                                                if ($contador == 0) { ?>
                                                    <span>Nenhum cliente encontrado.</span>
                                                <?php }
                                                ?>
                                            </div>
                                        </div>
                        <?php
                                    } else {
                                        echo "Erro ao decodificar a resposta JSON ou campos ausentes.";
                                    }
                                    curl_close($ch);
                                }
                            }
                        }
                    } else { ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-12">
                                    <h5 style="text-align: center; margin-top: 30px;" class="card-title">Nenhuma CTO vinculada ao incidente.</h5>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </section>
    </main>
<?php } else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>