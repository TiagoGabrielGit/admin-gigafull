<?php
session_start();
if (isset($_SESSION['id'])) {
    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require  "../../../conexoes/conexao_pdo.php";

        $id = $_POST['idUsuario'];
        $notificaEmail = $_POST['notificaEmail'];
        $notificaTelegram = $_POST['notificaTelegram'];
        $chatIdTelegram = isset($_POST['chatIdTelegram']) && $_POST['chatIdTelegram'] !== '' ? $_POST['chatIdTelegram'] : null;

        // Define o estado de ativação com base no valor do radio button
        $notificaEmail = ($notificaEmail == 1) ? 1 : 0;
        $notificaTelegram = ($notificaTelegram == 1) ? 1 : 0;

        // Atualiza o estado de ativação do cadastro no banco de dados
        $updateSql = "UPDATE usuarios SET notify_email = :notify_email, notify_telegram = :notify_telegram, chatIdTelegram = :chatIdTelegram WHERE id = :id";
        $stmtUpdate = $pdo->prepare($updateSql);
        $stmtUpdate->bindParam(':notify_email', $notificaEmail);
        $stmtUpdate->bindParam(':notify_telegram', $notificaTelegram);
        $stmtUpdate->bindParam(':chatIdTelegram', $chatIdTelegram);
        $stmtUpdate->bindParam(':id', $id);
        $stmtUpdate->execute();

        // Redireciona para a página de visualização dos convites
        header("Location: /gerenciamento/usuarios/profile.php?id=$id");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
?>
