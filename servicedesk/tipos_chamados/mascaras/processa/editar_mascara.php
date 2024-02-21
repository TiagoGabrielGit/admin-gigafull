<?php
session_start();
if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['mascara_id'])) {
            require "../../../../conexoes/conexao_pdo.php";

            $mascara_id = $_POST['mascara_id'];
            $mascara_text = $_POST['mascara'];
            $status = $_POST['status'];

            $query_update = "UPDATE tipos_chamados_mascaras SET mascara = :mascara, active = :status WHERE id = :mascara_id";
            $stmt = $pdo->prepare($query_update);
            $stmt->bindParam(":mascara_id", $mascara_id, PDO::PARAM_INT);
            $stmt->bindParam(":mascara", $mascara_text, PDO::PARAM_STR);
            $stmt->bindParam(":status", $status, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: /servicedesk/tipos_chamados/mascaras/view.php?id=$mascara_id");
            exit();
        } else {
            header("Location: /servicedesk/tipos_chamados/mascaras/index.php");
            exit();
        }
    } else {
        header("Location: /servicedesk/tipos_chamados/mascaras/index.php");
        exit();
    }
} else {
    header('Location: /index.php');
    exit();
}
