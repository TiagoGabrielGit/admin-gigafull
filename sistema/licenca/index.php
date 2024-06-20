<?php
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');

$submenu_id = "63";
$uid = $_SESSION['id'];

// Consulta para verificar as permissões do usuário
$permissions_submenu = "
    SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = :uid AND pp.url_submenu = :submenu_id
";
$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions_submenu->bindParam(':submenu_id', $submenu_id, PDO::PARAM_INT);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    // Consulta para buscar a licença atual
    $busca_licenca = "
        SELECT *
        FROM licenca
        WHERE id = 1
    ";
    $exec_busca_licenca = $pdo->prepare($busca_licenca);
    $exec_busca_licenca->execute();
    $licenca_data = $exec_busca_licenca->fetch(PDO::FETCH_ASSOC);

    // Inicializa a variável validade
    $validade = '';

    // URL da API consulta_validade.php
    $apiUrl = 'https://gestao.gigafull.com.br/api/consulta_validade.php';

    // Dados a serem enviados via POST para a API
    $postData = [
        'licenca' => $licenca_data['licenca'],
    ];

    // Inicializa o CURL
    $ch = curl_init();

    // Configuração do CURL para a API consulta_validade.php
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ATENÇÃO: Para produção, verifique SSL corretamente
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout de 30 segundos

    // Executa a requisição
    $response = curl_exec($ch);

    // Verifica se ocorreu algum erro na requisição CURL
    if ($response === false) {
        $mensagem_busca_validade = '<div class="alert alert-danger" role="alert">Erro na requisição CURL: ' . curl_error($ch) . '</div>';
    } else {
        // Imprime a resposta crua para depuração
        echo '<pre>Resposta da API: ' . htmlspecialchars($response) . '</pre>';

        // Decodifica a resposta JSON da API
        $responseData = json_decode($response, true);

        // Verifica se a resposta JSON foi decodificada corretamente
        if (json_last_error() !== JSON_ERROR_NONE) {
            $mensagem_busca_validade = '<div class="alert alert-danger" role="alert">Erro ao decodificar a resposta JSON: ' . json_last_error_msg() . '</div>';
        } else {
            // Verifica o status da resposta
            if (isset($responseData['status']) && $responseData['status'] === 'success') {
                // Conversão da data de validade para o formato dd/mm/yyyy
                $dataValidadeOriginal = $responseData['validade'];
                try {
                    $dataValidade = new DateTime($dataValidadeOriginal);
                    $validade = $dataValidade->format('d/m/Y');
                } catch (Exception $e) {
                    $mensagem_busca_validade = '<div class="alert alert-danger" role="alert">Erro ao formatar a data: ' . htmlspecialchars($e->getMessage()) . '</div>';
                }
                $mensagem_busca_validade = "";
            } else {
                // Verifica se a chave 'message' está presente na resposta
                $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Resposta desconhecida da API';
                $mensagem_busca_validade = '<div class="alert alert-danger" role="alert">Erro ao consultar a validade da licença: ' . htmlspecialchars($errorMessage) . '</div>';
            }
        }
    }

    // Fecha a conexão CURL
    curl_close($ch);
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="text-left">
                                    <h5 class="card-title">Licença</h5>
                                </div>
                            </div>
                            <?php
                            if (isset($_SESSION['msg'])) {
                                if ($_SESSION['msg'] == 'success') {
                                    echo '<div class="alert alert-success" role="alert">Licença atualizada com sucesso!</div>';
                                    unset($_SESSION['msg']);
                                } elseif ($_SESSION['msg'] == 'error') {
                                    echo '<div class="alert alert-danger" role="alert">Erro ao atualizar a licença. Por favor, tente novamente.</div>';
                                    unset($_SESSION['msg']);
                                }
                            }
                            ?>

                            <?php
                            if (!empty($mensagem_busca_validade)) {
                                echo $mensagem_busca_validade;
                            }
                            ?>
                            <hr class="sidebar-divider">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form action="processa/update.php" method="POST">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="licenca" class="form-label">Licença</label>
                                                <textarea rows="5" style="resize: none;" id="licenca" name="licenca" class="form-control"><?php echo htmlspecialchars($licenca_data['licenca']); ?></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="text-center">
                                            <button class="btn btn-sm btn-danger" type="submit">Aplicar Licença</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-4">
                                    <div class="col-6">
                                        <label for="validade" class="form-label">Validade</label>
                                        <input disabled readonly id="validade" name="validade" class="form-control" value="<?php echo isset($validade) ? $validade : ''; ?>">
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
