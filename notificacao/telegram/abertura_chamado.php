<?php
session_start();
if (isset($_SESSION['id']) &&  $_SERVER["REQUEST_METHOD"] == "POST") {
    //if (isset($_SESSION['id'])) {
    require "../../composer/vendor/autoload.php";
    require "../../conexoes/conexao_pdo.php";

    $consulta_habilitado =
        "SELECT nt.active as active
    FROM notificacao_telegram as nt
    WHERE nt.notificacao_id = 1 ";

    $result_habilitado = $pdo->query($consulta_habilitado);
    $c_habilitado = $result_habilitado->fetch(PDO::FETCH_ASSOC);
    $active = $c_habilitado['active'];

    if ($active == 1) {
        $query_token = "SELECT it.token FROM integracao_telegram as it WHERE id = 1";
        $r_query_token = $pdo->query($query_token);
        $c_query_token = $r_query_token->fetch(PDO::FETCH_ASSOC);
        $token = $c_query_token['token'];

        $id_chamado = $_POST['id_chamado'];
        //$id_chamado = '322';
        $infos_chamado =
            "SELECT 
            c.assuntoChamado AS assunto,  
            c.relato_inicial AS relato, 
            DATE_FORMAT(c.data_abertura, '%d/%m/%Y %H:%i') AS data_abertura, 
            tc.tipo AS tipo_chamado, 
            e.fantasia AS empresa,
            p.nome as solicitante
            FROM chamados as c
            LEFT JOIN  tipos_chamados as tc ON tc.id = c.tipochamado_id
            LEFT JOIN empresas as e ON e.id = c.empresa_id
            LEFT JOIN usuarios as u ON u.id = c.solicitante_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            WHERE c.id = $id_chamado";

        // Executa a consulta no banco de dados
        $r_infos_chamado = $pdo->query($infos_chamado);
        $c_infos_chamado = $r_infos_chamado->fetch(PDO::FETCH_ASSOC);
        $titulo = $c_infos_chamado['assunto'];
        $relato = $c_infos_chamado['relato'];
        $data_abertura = $c_infos_chamado['data_abertura'];
        $tipo_chamado = $c_infos_chamado['tipo_chamado'];
        $empresa = $c_infos_chamado['empresa'];
        $solicitante = $c_infos_chamado['solicitante'];


        $lista_destinatarios =
            "SELECT u.chatIdTelegram as 'chatIdTelegram'
            FROM usuarios u
            JOIN pessoas p ON p.id = u.pessoa_id
            WHERE u.notify_telegram = 1 and u.notify_email_abertura = 1 and u.active = 1
            
            UNION

            SELECT u.chatIdTelegram as 'chatIdTelegram'
            FROM usuarios u
            JOIN equipes_integrantes ei1 ON u.id = ei1.integrante_id
            JOIN equipes_integrantes ei2 ON ei1.equipe_id = ei2.equipe_id
            JOIN chamados c ON ei2.integrante_id = c.solicitante_id
            JOIN pessoas p ON p.id = u.pessoa_id 
            WHERE c.id = $id_chamado and u.notify_telegram = 1 and u.notify_email_abertura = 2 and u.active = 1";

        // Executa a consulta no banco de dados
        $result = $pdo->query($lista_destinatarios);

        if ($result->rowCount() > 0) {
            $destinatarios = array();

            $mensagem = "*Novo Chamado Aberto*\n\n";
            $mensagem .= "Chamado ID: $id_chamado\n";
            $mensagem .= "Empresa: $empresa\n";
            $mensagem .= "Solicitante: $solicitante\n";
            $mensagem .= "Tipo Chamdo: $tipo_chamado\n";
            $mensagem .= "Data Abertura: $data_abertura\n\n";
            $mensagem .= "*Assunto:*\n";
            $mensagem .= "$titulo\n\n";
            $mensagem .= "*Relato:*\n";
            $mensagem .= "$relato";

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $chat_id = $row['chatIdTelegram'];
                $destinatarios[] = $chat_id;

                \TelegramBot\Telegram::setToken($token);
                \TelegramBot\CrashPad::setDebugMode($chat_id);


                $result = \TelegramBot\Request::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $mensagem,
                    'parse_mode' => 'Markdown',

                ]);

                echo $result->getRawData(false);
            }
        } else {
            echo "Error: Nenhum resultado encontrado.";
        }
    } else {
        echo "Error: O envio de mensagem não está habilitado.";
    }
} else {
    header("Location: /index.php");
    exit();
}
