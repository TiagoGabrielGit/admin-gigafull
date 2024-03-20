<?php
session_start();

if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['statusChamado']) && isset($_POST['statusColor'])) {
            require "../../../../conexoes/conexao_pdo.php";

            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->prepare("INSERT INTO chamados_status (status_chamado, color, cadastroDefault, active) VALUES (:status, :cor_referencia, '0', '1')");

                $stmt->bindParam(':status', $_POST['statusChamado']);
                $stmt->bindParam(':cor_referencia', $_POST['statusColor']);

                $stmt->execute();

                header("Location: /servicedesk/tipos_chamados/status/index.php");
                exit();
            } catch (PDOException $e) {
                echo "Erro ao inserir dados no banco de dados: " . $e->getMessage();
            }

            $pdo = null;
        } else {
            header("Location: /servicedesk/tipos_chamados/status/index.php");
            exit();
        }
    } else {
        header("Location: /servicedesk/tipos_chamados/status/index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
