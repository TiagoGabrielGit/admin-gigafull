<?php
session_start();

    require "../../../conexoes/conexao_pdo.php";

    $integracao_voalle =
        "SELECT
            iv.id as id,
            iv.syndata as syndata,
            iv.api_request_token as api_request_token,
            iv.urlVoalle as urlVoalle,
            iv.usuario_integracao as usuarioIntegracao,
            iv.senha_integracao as senhaIntegracao,
            iv.active as active
            FROM
            integracao_voalle as iv
            WHERE
            iv.id = 1";

    $r_integracao_voalle = $pdo->query($integracao_voalle);
    $c_integracao_voalle = $r_integracao_voalle->fetch(PDO::FETCH_ASSOC);

    if ($c_integracao_voalle['active'] == 1) {
        $api_request_token = $c_integracao_voalle['api_request_token'];
        $urlVoalle = $c_integracao_voalle['urlVoalle'];
        $urlAPI = $urlVoalle . $api_request_token;
        $usuarioIntegracao = $c_integracao_voalle['usuarioIntegracao'];
        $senhaIntegracao = $c_integracao_voalle['senhaIntegracao'];
        $syndata = $c_integracao_voalle['syndata'];
        
        $data = array(
            'grant_type' => 'password',
            'scope' => 'syngw synpaygw offline_access',
            'client_id' => 'synauth',
            'client_secret' => 'df956154024a425eb80f1a2fc12fef0c',
            'username' => $usuarioIntegracao, // Substitua 'usuário' pelo nome de usuário real
            'password' => $senhaIntegracao, // Substitua 'senha' pela senha real
            'syndata' => $syndata
        );

        // Monta os dados no formato x-www-form-urlencoded
        $postData = http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlAPI);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Desabilitar em Produção
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Content-Length: ' . strlen($postData)
        ));

        $response = curl_exec($ch);

        if ($response === false) {
            echo "Erro na solicitação cURL: " . curl_error($ch);
        } else {
            $responseData = json_decode($response, true);

            if ($responseData !== null && isset($responseData['access_token']) && isset($responseData['expires_in'])) {
                $access_token = $responseData['access_token'];
                $expires_in = $responseData['expires_in'];

                // Calcule o timestamp de expiração somando expires_in em segundos ao tempo atual
                $token_expire_timestamp = time() + $expires_in;

                // Formate o timestamp no formato DATETIME
                $token_expire_datetime = date('Y-m-d H:i:s', $token_expire_timestamp);

                // Atualize os valores na tabela integracao_voalle
                $updateQuery = "UPDATE integracao_voalle SET token = :token, token_expire = :token_expire WHERE id = 1";
                $updateStatement = $pdo->prepare($updateQuery);
                $updateStatement->bindParam(':token', $access_token);
                $updateStatement->bindParam(':token_expire', $token_expire_datetime);

                if ($updateStatement->execute()) {
                    // Sucesso: o access_token e o token_expire foram atualizados na tabela
                    header('Content-Type: application/json');
                    echo json_encode(array('access_token' => $access_token, 'token_expire' => $token_expire_datetime));
                } else {
                    echo $responseData;
                    echo "Erro ao atualizar o token na tabela.";
                }
            } else {
                echo "Resposta da API não contém access_token ou expires_in válidos.";
            }
        }

        curl_close($ch);
    } else {
        echo "Integração não ativa";
    }
