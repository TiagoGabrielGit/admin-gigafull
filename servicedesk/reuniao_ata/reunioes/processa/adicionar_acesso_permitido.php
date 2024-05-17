<?php
session_start();

if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    $id_reuniao = $_POST['id_reuniao'];
    $stmt = $pdo->prepare("INSERT INTO ata_reuniao_acesso (id_reuniao, id_usuario, active) VALUES (:id_reuniao, :id_usuario, 1)");
    $stmt->bindParam(':id_reuniao', $id_reuniao);
    $stmt->bindParam(':id_usuario', $_POST['usuarioID']);
    $stmt->execute();
    header("Location: /servicedesk/reuniao_ata/reunioes/view.php?id=$id_reuniao");
    exit();
} else {
    header("Location: /index.php");
    exit();
}
