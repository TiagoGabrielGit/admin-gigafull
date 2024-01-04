<?php
require "../conexoes/conexao_pdo.php";
require "texts.php";
require "../composer/vendor/autoload.php";


$query = "SELECT token FROM integracao_telegram";
$stmt = $pdo->query($query);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$bot_token = $result['token'];

\TelegramBot\Telegram::setToken($bot_token);
$update = \TelegramBot\Telegram::getUpdate();

if (isset($update->message)) {
    $message = $update->getMessage();
    $chatId = $message->getChat()->getId();
    $text = $message->getText();
    $sql_conversacao =
        "SELECT * 
    FROM chat_telegram 
    WHERE chat_id = :chatId and (fase_conversacao != 10000 and last_conversacao > DATE_SUB(NOW(), INTERVAL 5 MINUTE))
    ";

    $stmt = $pdo->prepare($sql_conversacao);
    $stmt->bindParam(':chatId', $chatId);
    $stmt->execute();
    $existingConversation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingConversation) {
        \TelegramBot\Telegram::setToken($bot_token);
        \TelegramBot\CrashPad::setDebugMode($chatId);

        $mensagem_f0_1 = \TelegramBot\Request::sendMessage([
            'chat_id' => $chatId,
            'text' => $text_f0_msg1,
            'parse_mode' => 'Markdown',
        ]);

        $mensagem_f0_2 = \TelegramBot\Request::sendMessage([
            'chat_id' => $chatId,
            'text' => $text_f0_msg2,
            'parse_mode' => 'Markdown',
        ]);

        $mensagem_f0_4 = \TelegramBot\Request::sendMessage([
            'chat_id' => $chatId,
            'text' => $text_f0_msg4,
            'parse_mode' => 'Markdown',
        ]);

        // Insira um novo registro na tabela chat_telegram para iniciar a conversa
        $stmt = $pdo->prepare("INSERT INTO chat_telegram (chat_id, inicio_conversacao, last_conversacao, fase_conversacao) VALUES (:chatId, NOW(), NOW(), 0)");
        $stmt->bindParam(':chatId', $chatId);
        $stmt->execute();
    } else {
        $idConversacao = $existingConversation['id'];
        $faseConversacao = $existingConversation['fase_conversacao'];
        if (strtolower($text) == "encerrar") {
            \TelegramBot\Telegram::setToken($bot_token);
            \TelegramBot\CrashPad::setDebugMode($chatId);
            $result = \TelegramBot\Request::sendMessage([
                'chat_id' => $chatId,
                'text' => "Este atendimento foi encerrado.",
            ]);
            $stmtUpdate = $pdo->prepare("UPDATE chat_telegram SET fase_conversacao = 10000, last_conversacao = NOW(), fim_conversacao = NOW() WHERE id = :id");
            $stmtUpdate->bindParam(':id', $idConversacao);
            $stmtUpdate->execute();
        } else if (strtolower($text) == "menu") {
            \TelegramBot\Telegram::setToken($bot_token);
            \TelegramBot\CrashPad::setDebugMode($chatId);
            $result = \TelegramBot\Request::sendMessage([
                'chat_id' => $chatId,
                'text' => $text_f0_msg5,
                'parse_mode' => 'Markdown',

            ]);
            $stmtUpdate = $pdo->prepare("UPDATE chat_telegram SET fase_conversacao = 3, last_conversacao = NOW() WHERE id = :id");
            $stmtUpdate->bindParam(':id', $idConversacao);
            $stmtUpdate->execute();
        } else {
            if ($faseConversacao == 0) {
                $consulta_cfp =
                    "SELECT ctc.*
                FROM chat_telegram_contacts as ctc
                WHERE ctc.people_cpf = :people_cpf and active = 1";

                $stmt = $pdo->prepare($consulta_cfp);
                $stmt->bindParam(':people_cpf', $text);
                $stmt->execute();

                $existingCPF = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$existingCPF) {
                    \TelegramBot\Telegram::setToken($bot_token);
                    \TelegramBot\CrashPad::setDebugMode($chatId);
                    $result = \TelegramBot\Request::sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'CPF: ' . $text . ' não localizado, por favor digite novamente!',
                    ]);
                } else {
                    $people_name = $existingCPF['people_name'];
                    $id_contact = $existingCPF['id'];

                    $stmtUpdate = $pdo->prepare("UPDATE chat_telegram SET fase_conversacao = 3, last_conversacao = NOW(), chat_telegram_contacts_id = :ctci WHERE id = :id");
                    $stmtUpdate->bindParam(':id', $idConversacao);
                    $stmtUpdate->bindParam(':ctci', $id_contact);

                    $stmtUpdate->execute();

                    \TelegramBot\Telegram::setToken($bot_token);
                    \TelegramBot\CrashPad::setDebugMode($chatId);
                    $mensagem_1 = \TelegramBot\Request::sendMessage([
                        'chat_id' => $chatId,
                        'text' => '*' . $people_name . '*' . ' - Estamos iniciando o seu atendimento.',
                        'parse_mode' => 'Markdown',

                    ]);

                    $mensagem_2 = \TelegramBot\Request::sendMessage([
                        'chat_id' => $chatId,
                        'text' => $text_f0_msg3,
                        'parse_mode' => 'Markdown',
                    ]);

                    $mensagem_3 = \TelegramBot\Request::sendMessage([
                        'chat_id' => $chatId,
                        'text' => $text_f0_msg5,
                        'parse_mode' => 'Markdown',

                    ]);

                }
            } else if ($faseConversacao == 3) {
                $menu_digitado = $text;
                switch ($menu_digitado) {
                    case "1":
                        \TelegramBot\Telegram::setToken($bot_token);
                        \TelegramBot\CrashPad::setDebugMode($chatId);
                        $result = \TelegramBot\Request::sendMessage([
                            'chat_id' => $chatId,
                            'text' => "Selecione o método de busca: \n1. Através da CTO",
                        ]);
                        $stmtUpdate = $pdo->prepare("UPDATE chat_telegram SET fase_conversacao = 10, last_conversacao = NOW() WHERE id = :id");
                        $stmtUpdate->bindParam(':id', $idConversacao);
                        $stmtUpdate->execute();
                        break;
                    case "2":
                        \TelegramBot\Telegram::setToken($bot_token);
                        \TelegramBot\CrashPad::setDebugMode($chatId);
                        $result = \TelegramBot\Request::sendMessage([
                            'chat_id' => $chatId,
                            'text' => 'Esta opção se encontra em desenvolvimento, escolha outra opção.'
                        ]);
                        break;
                    default:
                        \TelegramBot\Telegram::setToken($bot_token);
                        \TelegramBot\CrashPad::setDebugMode($chatId);
                        $result = \TelegramBot\Request::sendMessage([
                            'chat_id' => $chatId,
                            'text' => 'Opção inválida, digite novamente. ',
                        ]);
                }
            } else if ($faseConversacao == 10) {
                $metodo_digitado = $text;
                switch ($metodo_digitado) {
                    case "1":
                        \TelegramBot\Telegram::setToken($bot_token);
                        \TelegramBot\CrashPad::setDebugMode($chatId);
                        $result = \TelegramBot\Request::sendMessage([
                            'chat_id' => $chatId,
                            'text' => "Digite a CTO no formato exemplo: *3-1-1*",
                            'parse_mode' => 'Markdown',
                            // Indica que você está usando Markdown
                        ]);
                        $stmtUpdate = $pdo->prepare("UPDATE chat_telegram SET fase_conversacao = 18, last_conversacao = NOW() WHERE id = :id");
                        $stmtUpdate->bindParam(':id', $idConversacao);
                        $stmtUpdate->execute();
                        break;
                    default:
                        \TelegramBot\Telegram::setToken($bot_token);
                        \TelegramBot\CrashPad::setDebugMode($chatId);
                        $result = \TelegramBot\Request::sendMessage([
                            'chat_id' => $chatId,
                            'text' => 'Método inválido, digite novamente. ',
                        ]);
                }
            } else if ($faseConversacao == 18) {
                $ct_busca = $text;
                $cto_digitada = '%-' . $ct_busca . '%';
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Consulta SQL usando parâmetros para evitar injeção de SQL
                    $sql = "SELECT gc.* 
                        FROM gpon_ctos as gc
                        WHERE gc.title LIKE :cto_digitada";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':cto_digitada', $cto_digitada, PDO::PARAM_STR);
                    $stmt->execute();
                    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($resultados)) {
                        // Se não houver resultados, enviar mensagem informando
                        \TelegramBot\Telegram::setToken($bot_token);
                        \TelegramBot\CrashPad::setDebugMode($chatId);
                        $result = \TelegramBot\Request::sendMessage([
                            'chat_id' => $chatId,
                            'text' => "Nenhuma CTO encontrada para a busca de CTO: *{$text}*, por favor, digite novamente.",
                            'parse_mode' => 'Markdown',
                        ]);
                    } else {
                        $mensagem = '';
                        $quantidade_incidentes = false;

                        foreach ($resultados as $cto) {
                            $cto_id = $cto['id'];
                            $sql_incidentes =
                                "SELECT gc.title as title, DATE_FORMAT(i.previsaoNormalizacao, '%d/%m/%Y %H:%i') as previsao_formatada, iclass.classificacao                            FROM incidentes_ctos as ic
                            LEFT JOIN incidentes as i ON i.id = ic.incidente_id
                            LEFT JOIN incidentes_classificacao as iclass ON iclass.id = i.classificacao
                            LEFT JOIN gpon_ctos as gc ON gc.id = ic.cto_id
                            WHERE ic.cto_id = :cto_id and i.active = 1";
                            $stmt_incidentes = $pdo->prepare($sql_incidentes);
                            $stmt_incidentes->bindParam(':cto_id', $cto_id, PDO::PARAM_INT);
                            $stmt_incidentes->execute();
                            $incidentes = $stmt_incidentes->fetchAll(PDO::FETCH_ASSOC);

                            if (!empty($incidentes)) {
                                $mensagem .= "*Incidente encontrado*\n";
                                foreach ($incidentes as $incidente) {
                                    $quantidade_incidentes = true;

                                    $mensagem .= "CTO: {$incidente['title']}\n";
                                    $mensagem .= "Classificação: {$incidente['classificacao']}\n";
                                    $mensagem .= "Previsão de Normalização: {$incidente['previsao_formatada']}\n\n";
                                }
                            }
                        }

                        if ($quantidade_incidentes == true) {
                            \TelegramBot\Telegram::setToken($bot_token);
                            \TelegramBot\CrashPad::setDebugMode($chatId);
                            $result = \TelegramBot\Request::sendMessage([
                                'chat_id' => $chatId,
                                'text' => $mensagem,
                                'parse_mode' => 'Markdown',
                            ]);
                        } else {
                            $mensagem .= 'Nenhum incidente encontrado para a CTO digitada: *' . $ct_busca . '*';
                            \TelegramBot\Telegram::setToken($bot_token);
                            \TelegramBot\CrashPad::setDebugMode($chatId);
                            $result = \TelegramBot\Request::sendMessage([
                                'chat_id' => $chatId,
                                'text' => $mensagem,
                                'parse_mode' => 'Markdown',
                            ]);
                        }

                        $stmtUpdate = $pdo->prepare("UPDATE chat_telegram SET last_conversacao = NOW() WHERE id = :id");
                        $stmtUpdate->bindParam(':id', $idConversacao);
                        $stmtUpdate->execute();
                    }

                } catch (PDOException $e) {
                    echo "Erro de conexão: " . $e->getMessage();
                }

                $pdo = null;
            } else {
                \TelegramBot\Telegram::setToken($bot_token);
                \TelegramBot\CrashPad::setDebugMode($chatId);
                $result = \TelegramBot\Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Fase não encontrada.',
                ]);
            }
        }
    }
}
