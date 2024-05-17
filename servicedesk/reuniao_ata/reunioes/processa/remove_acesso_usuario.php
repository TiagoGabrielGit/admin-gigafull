<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $acessotId = $_POST['id'];

        $query_update = "UPDATE ata_reuniao_acesso SET active = 0 WHERE id = :id";
        $stmt = $pdo->prepare($query_update);
        $stmt->bindParam(':id', $acessotId, PDO::PARAM_INT);

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
