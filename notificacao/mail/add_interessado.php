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

    $idChamado = $_POST['idChamado'];
    $email = $_POST['email'];

    $infos_chamado =
        "SELECT
    c.assuntoChamado as assunto,
    c.relato_inicial as relato,
    c.data_abertura as data_abertura,
    tc.tipo as tipo_chamado,
    e.fantasia as empresa,
    p.nome as atendente
    FROM
    chamados as c
    LEFT JOIN
    tipos_chamados as tc
    ON
    tc.id = c.tipochamado_id
    LEFT JOIN
    empresas as e
    ON
    e.id = c.empresa_id
    LEFT JOIN
    usuarios as u
    ON
    u.id = c.atendente_id
    LEFT JOIN
    pessoas as p
    ON
    p.id = u.pessoa_id
    WHERE
    c.id = $idChamado";

    // Executa a consulta no banco de dados
    $r_infos_chamado = $pdo->query($infos_chamado);
    $c_infos_chamado = $r_infos_chamado->fetch(PDO::FETCH_ASSOC);
    $titulo = $c_infos_chamado['assunto'];
    $relato = $c_infos_chamado['relato'];
    $relato = $relato;
    $data_abertura = $c_infos_chamado['data_abertura'];
    $tipo_chamado = $c_infos_chamado['tipo_chamado'];
    $empresa = $c_infos_chamado['empresa'];

    //Assunto do email
    $assunto = "SmartControl - Adicionado como interessado no chamado " . $idChamado;

    // Mensagem do email
    $mensagem = "<b>Este e-mail foi adicionado como interessado no chamado $idChamado.</b><br>";

    $mensagem .= "Chamado ID: $idChamado
    Empresa: $empresa
    Tipo Chamdo: $tipo_chamado
    Assunto: $titulo
    Data Abertura: $data_abertura
    
    <b>Relato da Abertura:</b>
    $relato";

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
