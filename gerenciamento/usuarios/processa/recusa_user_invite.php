<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require "../../../conexoes/conexao_pdo.php";

    // Validação do parâmetro 'id'
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // ID inválido, faça o tratamento apropriado
        echo "ID inválido.";
        exit;
    }

    // Prepare a query SQL
    $query = "SELECT
        uia.email as 'email'
        FROM
        usuario_invite_accept as uia
        WHERE
        uia.id = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $update_status = "UPDATE usuario_invite_accept SET  status = '3' WHERE id = :id";
        $stmt_update_status = $pdo->prepare($update_status);
        $stmt_update_status->bindParam(':id', $id);
        if ($stmt_update_status->execute()) {

            $email = $result['email'];
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $protocol = 'https';
            } else {
                $protocol = 'http';
            }
            $documentRoot = $_SERVER['DOCUMENT_ROOT'];
            $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/notificacao/mail/recusa_invite.php';

            $data = array(
                'email' => $email
            );

            // Inicializa o cURL
            $curl = curl_init($url);

            // Configura as opções do cURL
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // Executa a requisição cURL
            $response = curl_exec($curl);

            // Verifica se ocorreu algum erro durante a requisição
            if ($response === false) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit; // Encerra a execução do script após o redirecionamento
            } else {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit; // Encerra a execução do script após o redirecionamento
            }

            // Fecha a conexão cURL
            curl_close($curl);
        }
    }
}
