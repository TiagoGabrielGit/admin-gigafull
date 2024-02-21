<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../composer/vendor/autoload.php";
    require "../../conexoes/conexao_pdo.php";

    $consulta_habilitado =
        "SELECT nt.active as active 
    FROM notificacao_telegram as nt
    WHERE nt.notificacao_id = 3";
    $stmt_habilitado = $pdo->prepare($consulta_habilitado);
    $stmt_habilitado->execute();
    $resultado_habilitado = $stmt_habilitado->fetch(PDO::FETCH_ASSOC);
    $active = $resultado_habilitado['active'];

    if ($active == 1) {
        $query_token =
            "SELECT it.token
            FROM notificacao_telegram as nt
            LEFT JOIN integracao_telegram as it ON it.id = nt.token_id
            WHERE nt.notificacao_id = 3 and it.active = 1";

        $stmt_token = $pdo->prepare($query_token);
        $stmt_token->execute();
        if ($stmt_token->rowCount() > 0) {
            $resultado_token = $stmt_token->fetch(PDO::FETCH_ASSOC);
            $token = $resultado_token['token'];

            $id_chamado = $_POST['id_chamado'];
            $consulta_chamado = "SELECT
            c.assuntoChamado as assunto,
            c.relato_inicial as relato,
            c.data_abertura as data_abertura,
            tc.tipo as tipo_chamado,
            e.fantasia as empresa,
            p.nome as atendente
            FROM chamados as c
            LEFT JOIN tipos_chamados as tc ON tc.id = c.tipochamado_id
            LEFT JOIN empresas as e ON e.id = c.empresa_id
            LEFT JOIN usuarios as u ON u.id = c.atendente_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            WHERE c.id = ?";
            $stmt_chamado = $pdo->prepare($consulta_chamado);
            $stmt_chamado->execute([$id_chamado]);
            $c_infos_chamado = $stmt_chamado->fetch(PDO::FETCH_ASSOC);

            $titulo = $c_infos_chamado['assunto'];
            $relato = $c_infos_chamado['relato'];
            $data_abertura = $c_infos_chamado['data_abertura'];
            $tipo_chamado = $c_infos_chamado['tipo_chamado'];
            $empresa = $c_infos_chamado['empresa'];

            // Último relato
            $ultimo_relato_query = "SELECT
            p.nome as 'relatante',
            cr.relato as 'relato',
            cr.private as 'privacidade'
            FROM chamado_relato as cr
            LEFT JOIN usuarios as u ON u.id = cr.relator_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            WHERE cr.chamado_id = ?
            ORDER BY cr.id DESC LIMIT 1";
            $stmt_ultimo_relato = $pdo->prepare($ultimo_relato_query);
            $stmt_ultimo_relato->execute([$id_chamado]);
            $c_ultimo_relato = $stmt_ultimo_relato->fetch(PDO::FETCH_ASSOC);
            $ultimo_relato = $c_ultimo_relato['relato'];
            $relatante = $c_ultimo_relato['relatante'];
            $privacidade = $c_ultimo_relato['privacidade'];

            // Construir lista de destinatários
            $lista_destinatarios = "";
            if ($privacidade == 1) { // Público
                $lista_destinatarios = "SELECT u.chatIdTelegram
                            FROM usuarios u
                            JOIN pessoas p ON p.id = u.pessoa_id
                            WHERE u.notify_telegram = 1
                            AND u.notify_email_relatos = 1
                            AND u.active = 1

                            UNION 

                            SELECT u.chatIdTelegram
                            FROM usuarios u
                            JOIN equipes_integrantes ei1 ON u.id = ei1.integrante_id
                            JOIN equipes_integrantes ei2 ON ei1.equipe_id = ei2.equipe_id
                            JOIN chamados c ON ei2.integrante_id = c.solicitante_id
                            JOIN pessoas p ON p.id = u.pessoa_id 
                            WHERE u.id != 9999
                            AND c.id = ?
                            AND u.notify_telegram = 1
                            AND u.notify_email_relatos = 2
                            AND u.active = 1

                            UNION

                            SELECT u.chatIdTelegram
                            FROM chamados as c
                            LEFT JOIN usuarios as u ON u.id = c.atendente_id
                            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                            WHERE c.id = ?
                            AND u.notify_telegram = 1";
            } else if ($privacidade == 2) { // Privado
                $lista_destinatarios = "SELECT u.chatIdTelegram
                            FROM usuarios u
                            JOIN pessoas p ON p.id = u.pessoa_id
                            WHERE u.notify_telegram = 1
                            AND u.notify_email_relatos = 1
                            AND u.active = 1

                            UNION

                            SELECT u.chatIdTelegram
                            FROM chamados as c
                            LEFT JOIN usuarios as u ON u.id = c.atendente_id
                            LEFT JOIN  pessoas as p ON p.id = u.pessoa_id
                            WHERE c.id = ?
                            AND u.notify_email = 1";
            }
            $stmt_destinatarios = $pdo->prepare($lista_destinatarios);

            if ($privacidade == 1) {
                $stmt_destinatarios->execute([$id_chamado, $id_chamado]);
            } else if ($privacidade == 2) {
                $stmt_destinatarios->execute([$id_chamado]);
            }

            if ($stmt_destinatarios->rowCount() > 0) {
                $destinatarios = array();

                $mensagem = "*Um novo relato foi adicionado no chamado $id_chamado por $relatante.*\n\n";
                $mensagem .= "Chamado ID: $id_chamado\n";
                $mensagem .= "Empresa: $empresa\n";
                $mensagem .= "Tipo Chamdo: $tipo_chamado\n";
                $mensagem .= "Data Abertura: $data_abertura\n\n";

                $mensagem .= "*Assunto: *\n";
                $mensagem .= "$titulo\n\n";
                $mensagem .= "*Relato da Abertura:*\n";
                $mensagem .= "$relato\n\n";

                $mensagem .= "*Relato Adicionado:*\n";
                $mensagem .= "$ultimo_relato";


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

                    // Avisar sobre o envio
                    echo 'Envio: ' . $chat_id . '<br>';
                    echo $result->getRawData(false) . '<br><br>';
                }
            } else {
                echo "Nenhum resultado encontrado.";
            }
        } else {
            echo "Nenhum token encontrado.";
        }
    } else {
        echo "O envio de e-mail não está habilitado.";
    }
}
