<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $participantId = $_POST['id'];

        $query_remove = "DELETE FROM ata_reuniao_participantes WHERE id = :id";
        $stmt = $pdo->prepare($query_remove);
        $stmt->bindParam(':id', $participantId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
} else {
    header("Location: /index.php");
    exit();
}
