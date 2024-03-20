<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['id']) && isset($_POST['statusChamado']) && isset($_POST['colorStatus']) && isset($_POST['situacao'])) {
            require "../../../../conexoes/conexao_pdo.php";
            $id = $_POST['id'];
            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->prepare("UPDATE chamados_status SET status_chamado = :status, color = :cor_referencia, active = :situacao WHERE id = :id");

                $stmt->bindParam(':status', $_POST['statusChamado']);
                $stmt->bindParam(':cor_referencia', $_POST['colorStatus']);
                $stmt->bindParam(':situacao', $_POST['situacao']);
                $stmt->bindParam(':id', $_POST['id']);

                $stmt->execute();

                header("Location: /servicedesk/tipos_chamados/status/view.php?id=$id");
                exit();
            } catch (PDOException $e) {
                echo "Erro ao atualizar dados no banco de dados: " . $e->getMessage();
            }

            $pdo = null;
        } else {
            header("Location: /servicedesk/tipos_chamados/status/view.php?id=$id");
            exit();
        }
    } else {
        header("Location: /servicedesk/tipos_chamados/status/view.php?id=$id");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
