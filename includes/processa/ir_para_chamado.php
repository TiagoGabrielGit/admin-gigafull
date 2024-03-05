<?php
session_start();
if (isset($_SESSION['id'])) {
    require "../../conexoes/conexao_pdo.php";
    $id_notificacao = $_GET['id'];

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("UPDATE smart_notification SET status = 2 WHERE id = :id");
        $stmt->execute(array(':id' => $id_notificacao));


        $stmt = $pdo->prepare("SELECT mensagem_tipo, chamado_id FROM smart_notification WHERE id = :id");
        $stmt->execute(array(':id' => $id_notificacao));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $mensagem_tipo = $row['mensagem_tipo'];
        $chamado_id = $row['chamado_id'];

        if ($mensagem_tipo == 3) {
            header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");
            exit();
        }
    } catch (PDOException $e) {
        // Em caso de erro de conexão ou consulta, você pode lidar com isso aqui
        echo "Erro: " . $e->getMessage();
    }
} else {
    header("Location: /index.php");
    exit();
}
