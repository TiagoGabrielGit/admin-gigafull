<?php
require "../composer/vendor/autoload.php";


$admin_id = 501960186;
$bot_token = '6903745578:AAFPVsBZTZIL1CY5Z1O1oMu1vb2lWxmyp7c';

\TelegramBot\Telegram::setToken($bot_token);
\TelegramBot\CrashPad::setDebugMode($admin_id);

$result = \TelegramBot\Request::sendMessage([
   'chat_id' => $admin_id,
   'text' => 'teste send message',
]);

echo $result->getRawData(false); // {"ok": true, "result": {...}}