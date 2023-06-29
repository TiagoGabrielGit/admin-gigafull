<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../conexoes/conexao_pdo.php";
    $server_id = '1000';

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocol = 'https';
    } else {
        $protocol = 'http';
    }
    $documentRoot = $_SERVER['DOCUMENT_ROOT'];
    $urlLogin = $protocol . '://' . $_SERVER['HTTP_HOST'];

    $user_id = $_POST['id'];
    $senha = $_POST['senha'];

    $sql_usuario =
        "SELECT
        p.nome as 'nome',
        p.email as 'email',
        u.senha as 'senha'
        FROM
        usuarios as u
        LEFT JOIN
        pessoas as p
        ON
        p.id = u.pessoa_id
        WHERE
        u.id = $user_id";
    // Executa a consulta no banco de dados
    $r_usuario = $pdo->query($sql_usuario);
    $c_usuario = $r_usuario->fetch(PDO::FETCH_ASSOC);
    $nome = $c_usuario['nome'];
    $email = $c_usuario['email'];

    //Assunto do email
    $assunto = "SmartControl - Cadastro de usuário aprovado";

    // Mensagem do email
    $mensagem = "<b>$nome, seu usuário foi aprovado, segue os dados de login:</b><br>";
    $mensagem .= "URL: $urlLogin
                Usuário: $email
                Senha: $senha
                
                No seu primeiro acesso, vai solicitar que você defina uma nova senha.";

    $relativePath = '/mail/sendmail_POST.php';

    $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $relativePath;

    // Dados a serem enviados
    $data = array(
        'destinatario' => $email,
        'assunto' => $assunto,
        'mensagem' => $mensagem,
        'servidorID' => $server_id
    );

    // Inicializar a sessão cURL
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
