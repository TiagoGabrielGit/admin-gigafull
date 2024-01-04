<?php
session_start();
if (isset($_SESSION['id'])) {
    require "../conexoes/conexao_pdo.php";
    require "../composer/vendor/autoload.php";

    $query = "SELECT token FROM integracao_telegram";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $bot_token = $result['token'];

    // Verificar se a solicitação foi feita via HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocol = 'https';
    } else {
        $protocol = 'http';
    }


    \TelegramBot\Telegram::setToken($bot_token);
    $response = \TelegramBot\Request::setWebhook([
        'url' => $protocol . '://' . $_SERVER['HTTP_HOST'] . '/telegram/conversation.php/' . $bot_token,
    ]);

    if ($response->isOk()) {
        echo "Webhook configurado com sucesso.\n";
        echo $response->getDescription() . "\n";
    } else {
        echo "Erro ao configurar o webhook:\n";
        echo $response->getDescription() . "\n";
    }
} else {
    echo "Usuário não logado.";
}