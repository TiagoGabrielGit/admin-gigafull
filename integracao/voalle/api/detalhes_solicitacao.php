<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require "../../../conexoes/conexao_pdo.php";
$integracao_voalle =
    "SELECT
            iv.token as token,
            iv.urlVoalle as urlVoalle,
            iv.api_detalhes_solicitacao as api_detalhes_solicitacao,
            iv.api_relatos_solicitacao as api_relatos_solicitacao,
            iv.token_expire as token_expire,
            iv.active as active
            FROM
            integracao_voalle as iv
            WHERE
            iv.id = 1";

$r_integracao_voalle = $pdo->query($integracao_voalle);
$c_integracao_voalle = $r_integracao_voalle->fetch(PDO::FETCH_ASSOC);

if ($c_integracao_voalle['active'] == 1) {
    if (isset($_GET['protocol']) && !empty($_GET['protocol'])) {

        $currentTimestamp = time();
        $tokenExpireTimestamp = strtotime($c_integracao_voalle['token_expire']);

        if ($tokenExpireTimestamp < $currentTimestamp) {
            $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
            $domain = $_SERVER['HTTP_HOST'];
            $baseUrl = $protocol . $domain;
            $tokenRequestUrl = $baseUrl . "/integracao/voalle/api/request_token.php";
            $ch = curl_init($tokenRequestUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseNewToken = curl_exec($ch);
            $responseNewTokenArray = json_decode($responseNewToken, true);

            if ($responseNewTokenArray && isset($responseNewTokenArray['access_token'])) {
                $c_integracao_voalle['token'] = $responseNewTokenArray['access_token'];
            }
        }

        $access_token = $c_integracao_voalle['token'];
        $urlVoalle = $c_integracao_voalle['urlVoalle'];
        $api_detalhes_solicitacao = $c_integracao_voalle['api_detalhes_solicitacao'];
        $api_relatos_solicitacao = $c_integracao_voalle['api_relatos_solicitacao'];
        $protocol = $_GET['protocol'];
        $url = $urlVoalle . $api_detalhes_solicitacao . "protocol=" . $protocol;

        $headers = [
            'Authorization: Bearer ' . $access_token
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        $responseData = [
            "solicitacao" => "",
            "relatos" => "",
        ];

        if (curl_errno($ch)) {
            echo 'Erro na requisição: ' . curl_error($ch);
        } else {
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_status >= 400) {
                echo 'Erro na requisição. Código de status HTTP: ' . $http_status;
            } else {
                // Exibe a resposta da primeira API formatada
                $firstApiResponse = json_decode($response, true);
                $responseData['solicitacao'] = $firstApiResponse;

                // Crie um array para armazenar as respostas
                $allResponses = [
                    'detalhes_solicitacao' => $firstApiResponse
                ];

                if ($firstApiResponse !== null && isset($firstApiResponse['response']['assignmentId'])) {
                    $assignmentId = $firstApiResponse['response']['assignmentId'];

                    // Agora você pode usar o assignmentId para fazer a segunda solicitação
                    $secondApiUrl = $urlVoalle . $api_relatos_solicitacao . 'assignmentId=' . $assignmentId;

                    // Define os cabeçalhos para a segunda solicitação
                    $secondApiHeaders = [
                        'Authorization: Bearer ' . $access_token
                    ];

                    $secondCh = curl_init($secondApiUrl);

                    curl_setopt($secondCh, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($secondCh, CURLOPT_HTTPHEADER, $secondApiHeaders);
                    curl_setopt($secondCh, CURLOPT_RETURNTRANSFER, true);

                    $secondApiResponse = curl_exec($secondCh);

                    if (curl_errno($secondCh)) {
                        $allResponses['relatos_solicitacao'] = ['error' => 'Erro na requisição da segunda API: ' . curl_error($secondCh)];
                    } else {
                        $secondHttpStatus = curl_getinfo($secondCh, CURLINFO_HTTP_CODE);
                        if ($secondHttpStatus >= 400) {
                            $allResponses['relatos_solicitacao'] = ['error' => 'Erro na requisição da segunda API. Código de status HTTP: ' . $secondHttpStatus];
                        } else {
                            // Exibe a resposta da segunda API formatada
                            $secondApiResponseData = json_decode($secondApiResponse, true);
                            $responseData['relatos'] = $secondApiResponseData;
                            $allResponses['relatos_solicitacao'] = $secondApiResponseData;
                        }
                    }

                    echo json_encode($responseData);

                    curl_close($secondCh);
                } else {
                    $allResponses['relatos_solicitacao'] = ['error' => "Chave 'assignmentId' não encontrada no JSON retornado pela primeira API."];
                }
            }
        }

        curl_close($ch);
    } else {
        echo "Número de protocolo não informado.";
    }
} else {
    echo "Integração não ativa";
}
