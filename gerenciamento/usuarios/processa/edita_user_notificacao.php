<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUser = $_POST['notificacaoIdUser'];
    require "../../../conexoes/conexao_pdo.php";
    try {

        // Prepare a consulta SQL
        $sql = "UPDATE usuarios SET 
            notify_email = :notificaEmail,
            notify_telegram = :notificaTelegram,
            chatIdTelegram = :chatIdTelegram,
            notify_email_abertura = :notificaEmailAbertura,
            notify_email_encaminhamento = :notificaEmailEncaminhamento,
            notify_email_relatos = :notificaEmailRelatos,
            notify_email_apropriacao = :notificaEmailApropriacao,
            notify_email_execucao = :notificaEmailExecucao
            WHERE id = :idUsuario";

        // Preparar a declaração SQL
        $stmt = $pdo->prepare($sql);

        // Substituir os valores dos parâmetros com os valores do formulário
        $stmt->bindParam(':notificaEmail', $_POST['notificaEmail']);
        $stmt->bindParam(':notificaTelegram', $_POST['notificaTelegram']);
        $stmt->bindParam(':chatIdTelegram', $_POST['chatID']);
        $stmt->bindParam(':notificaEmailAbertura', $_POST['notificaAbertura']);
        $stmt->bindParam(':notificaEmailEncaminhamento', $_POST['notificaEncaminhamento']);
        $stmt->bindParam(':notificaEmailRelatos', $_POST['notificaRelatos']);
        $stmt->bindParam(':notificaEmailApropriacao', $_POST['notificaApropriacao']);
        $stmt->bindParam(':notificaEmailExecucao', $_POST['notificaExecucao']);

        $stmt->bindParam(':idUsuario', $_POST['notificacaoIdUser']);
        $stmt->execute();

        header("Location: /gerenciamento/usuarios/view.php?id=$idUser");
        exit;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        header("Location: /gerenciamento/usuarios/view.php?id=$idUser");
        exit;
    }
}
