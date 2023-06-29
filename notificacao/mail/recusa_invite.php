<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../conexoes/conexao_pdo.php";
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocol = 'https';
    } else {
        $protocol = 'http';
    }
    $server_id = '1000';
    $email = $_POST['email'];
    $assunto = "SmartControl - Cadastro de usuário negada.";
    $mensagem = "<b>Entre em contato conosco para verificar sua solicitação de acesso</b><br>";
    $relativePath = '/mail/sendmail_POST.php';
    $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $relativePath;
    $data = array(
        'destinatario' => $email,
        'assunto' => $assunto,
        'mensagem' => $mensagem,
        'servidorID' => $server_id
    );

    $curl = curl_init();

    // Configurar a requisição POST
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // Permitir redirecionamento

    // Executar a requisição e obter a resposta
    $response = curl_exec($curl);

    // Verificar a resposta
    if ($response === false) {
        echo "Error: Erro ao enviar o e-mail.";
    } else {
        echo "Response:" . $response;
    }

    // Fechar a sessão cURL
    curl_close($curl);
}
