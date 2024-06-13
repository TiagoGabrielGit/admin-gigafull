<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['chamado_id_update_status'])) {
            $chamado_id = $_POST['chamado_id_update_status'];
            if (isset($_POST['relato_status']) && !empty($_POST['relato_status'])) {
                $relato = $_POST['relato_status'];
                $status = $_POST['status_afericao'];
                require "../../../conexoes/conexao_pdo.php";

                $query_update_afericao = "UPDATE afericao SET status = :status, relato = :relato WHERE chamado_id = :chamado_id";
                $stmt_update_afericao = $pdo->prepare($query_update_afericao);
                $stmt_update_afericao->bindParam(':status', $status);
                $stmt_update_afericao->bindParam(':relato', $relato);
                $stmt_update_afericao->bindParam(':chamado_id', $chamado_id);
                if ($stmt_update_afericao->execute()) {
                    header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");
                    exit;
                } else {
                    header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");
                    exit;
                }
            } else {
                header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");
                exit;
            }
        } else {
            header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");
            exit;
        }
    } else {
        echo "Este arquivo só pode ser acessado via método POST.";
    }
} else {
    header("/index.php");
    exit;
}
