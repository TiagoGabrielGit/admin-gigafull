<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    try {
        // Consulta à tabela integracao_ozmap para obter a URL da API e a chave de autenticação
        $queryIntegracaoOzmap = "SELECT urlAPI, chaveAutenticacao FROM integracao_ozmap LIMIT 1";
        $stmtIntegracaoOzmap = $pdo->query($queryIntegracaoOzmap);
        $integracaoOzmap = $stmtIntegracaoOzmap->fetch(PDO::FETCH_ASSOC);

        if (empty($integracaoOzmap['urlAPI']) || empty($integracaoOzmap['chaveAutenticacao'])) {
            echo json_encode(['success' => false, 'message' => 'Integração não configurada.']);
            exit();
        }

        $urlAPI = $integracaoOzmap['urlAPI'];
        $chaveAutenticacao = $integracaoOzmap['chaveAutenticacao'];

        // URL da API externa
        $apiUrl = $urlAPI . '/boxes?limit=10000000&filter=[{"property":"boxType","value":"5fcfa4943cc7170014e57b68","operator":"eq"}]';

        // Inicializa cURL
        $ch = curl_init();

        // Configurações cURL
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $chaveAutenticacao"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Adiciona esta linha para desabilitar a verificação do certificado SSL

        // Executa a requisição e obtém a resposta
        $response = curl_exec($ch);

        // Verifica se houve erro na requisição
        if (curl_errno($ch)) {
            throw new Exception("Erro ao chamar a API externa: " . curl_error($ch));
        }

        // Fecha a conexão cURL
        curl_close($ch);

        // Decodificar a resposta JSON
        $ctosExternas = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Erro ao decodificar a resposta da API externa.");
        }

        // Verificar se a resposta contém a chave "rows"
        if (!isset($ctosExternas['rows'])) {
            throw new Exception("Resposta da API não possui a estrutura esperada.");
        }

        // Percorrer as CTOs recebidas
        foreach ($ctosExternas['rows'] as $ctoExterna) {
            $titulo = $ctoExterna['name'];
            $nbintegration_code = $ctoExterna['id'];
            $latitude = $ctoExterna['lat'];
            $longitude = $ctoExterna['lng'];

            // Verificar se a CTO já existe na tabela gpon_ctos
            $queryVerifica = "SELECT COUNT(*) FROM gpon_ctos WHERE nbintegration_code = :nbintegration_code";
            $stmtVerifica = $pdo->prepare($queryVerifica);
            $stmtVerifica->bindParam(':nbintegration_code', $nbintegration_code, PDO::PARAM_STR);
            $stmtVerifica->execute();

            if ($stmtVerifica->fetchColumn() == 0) {
                // Inserir a nova CTO na tabela gpon_ctos
                $queryInsere = "INSERT INTO gpon_ctos (title, nbintegration_code, lat, lng) VALUES (:titulo, :nbintegration_code, :latitude, :longitude)";
                $stmtInsere = $pdo->prepare($queryInsere);
                $stmtInsere->bindParam(':titulo', $titulo, PDO::PARAM_STR);
                $stmtInsere->bindParam(':nbintegration_code', $nbintegration_code, PDO::PARAM_STR);
                $stmtInsere->bindParam(':latitude', $latitude, PDO::PARAM_STR);
                $stmtInsere->bindParam(':longitude', $longitude, PDO::PARAM_STR);
                $stmtInsere->execute();
            }
        }

        // Resposta de sucesso
        echo json_encode(['success' => true, 'message' => 'CTOs atualizadas com sucesso!']);
    } catch (Exception $e) {
        // Resposta de erro
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    header("Location: /index.php");
    exit();
}
?>
