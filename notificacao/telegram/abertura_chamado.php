<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../composer/vendor/autoload.php";
    require "../../conexoes/conexao_pdo.php";

    // Verifica se o envio de mensagem está habilitado
    $consulta_habilitado = "SELECT nt.active as active FROM notificacao_telegram as nt WHERE nt.notificacao_id = 1";
    $result_habilitado = $pdo->query($consulta_habilitado);
    $c_habilitado = $result_habilitado->fetch(PDO::FETCH_ASSOC);
    $active = $c_habilitado['active'];

    if ($active == 1) {
        // Obtém o token para enviar mensagens
        $query_token = "SELECT it.token FROM integracao_telegram as it WHERE id = 1";
        $r_query_token = $pdo->query($query_token);
        $c_query_token = $r_query_token->fetch(PDO::FETCH_ASSOC);
        $token = $c_query_token['token'];

        // Evita SQL injection utilizando prepared statements
        $id_chamado = $_POST['id_chamado'];
        $stmt = $pdo->prepare("SELECT c.assuntoChamado AS assunto, c.relato_inicial AS relato, DATE_FORMAT(c.data_abertura, '%d/%m/%Y %H:%i') AS data_abertura, tc.tipo AS tipo_chamado, e.fantasia AS empresa, p.nome as solicitante FROM chamados as c LEFT JOIN tipos_chamados as tc ON tc.id = c.tipochamado_id LEFT JOIN empresas as e ON e.id = c.empresa_id LEFT JOIN usuarios as u ON u.id = c.solicitante_id LEFT JOIN pessoas as p ON p.id = u.pessoa_id WHERE c.id = ?");
        $stmt->execute([$id_chamado]);
        $c_infos_chamado = $stmt->fetch(PDO::FETCH_ASSOC);


        // Verifica se há destinatários para enviar a mensagem
        $lista_destinatarios = "SELECT u.chatIdTelegram as 'chatIdTelegram' FROM usuarios u JOIN pessoas p ON p.id = u.pessoa_id WHERE u.notify_telegram = 1 and u.notify_email_abertura = 1 and u.active = 1 UNION SELECT u.chatIdTelegram as 'chatIdTelegram' FROM usuarios u JOIN equipes_integrantes ei1 ON u.id = ei1.integrante_id JOIN equipes_integrantes ei2 ON ei1.equipe_id = ei2.equipe_id JOIN chamados c ON ei2.integrante_id = c.solicitante_id JOIN pessoas p ON p.id = u.pessoa_id WHERE c.id = ? and u.notify_telegram = 1 and u.notify_email_abertura = 2 and u.active = 1 ORDER BY chatIdTelegram ASC";
        $stmt_destinatarios = $pdo->prepare($lista_destinatarios);
        $stmt_destinatarios->execute([$id_chamado]);

        if ($stmt_destinatarios->rowCount() > 0) {
            $destinatarios = array();
            $mensagem = "*Novo Chamado Aberto*\n\n";
            $mensagem .= "Chamado ID: $id_chamado\n";
            $mensagem .= "Empresa: {$c_infos_chamado['empresa']}\n";
            $mensagem .= "Solicitante: {$c_infos_chamado['solicitante']}\n";
            $mensagem .= "Tipo Chamdo: {$c_infos_chamado['tipo_chamado']}\n";
            $mensagem .= "Data Abertura: {$c_infos_chamado['data_abertura']}\n\n";
            $mensagem .= "*Assunto:*\n";
            $mensagem .= "{$c_infos_chamado['assunto']}\n\n";
            $mensagem .= "*Relato:*\n";
            $mensagem .= "{$c_infos_chamado['relato']}";

            $envios = '1';
            while ($row = $stmt_destinatarios->fetch(PDO::FETCH_ASSOC)) {
                $chat_id = $row['chatIdTelegram'];
                $destinatarios[] = $chat_id;

                \TelegramBot\Telegram::setToken($token);
                \TelegramBot\CrashPad::setDebugMode($chat_id);

                $result = \TelegramBot\Request::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $mensagem,
                    'parse_mode' => 'Markdown',
                ]);
                echo 'Envio: ' . $envios . ' - ' . $chat_id . '<br>';

                $envios++;

                echo $result->getRawData(false) . '<br><br>';
            }
        } else {
            echo "Error: Nenhum destinatário encontrado.";
        }
    } else {
        echo "Error: O envio de mensagem não está habilitado.";
    }
} else {
    header("Location: /index.php");
    exit();
}
