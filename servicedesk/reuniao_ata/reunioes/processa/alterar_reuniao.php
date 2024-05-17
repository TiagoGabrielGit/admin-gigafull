<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_reuniao = isset($_POST['id_reuniao']) ? (int)$_POST['id_reuniao'] : null;
        $novoStatus = isset($_POST['novoStatus']) ? $_POST['novoStatus'] : null;
        $novoLocal = isset($_POST['novoLocal']) ? $_POST['novoLocal'] : null;
        $novoInicio = isset($_POST['novoInicio']) ? $_POST['novoInicio'] : null;
        $novoFim = isset($_POST['novoFim']) ? $_POST['novoFim'] : null;

        $query =
            "UPDATE ata_reuniao
            SET status = :status, inicio = :novoInicio, fim = :novoFim, local = :novoLocal
            WHERE id = :id_reuniao";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':status', $novoStatus);
        $stmt->bindParam(':novoInicio', $novoInicio);
        $stmt->bindParam(':novoFim', $novoFim);
        $stmt->bindParam(':novoLocal', $novoLocal);

        $stmt->bindParam(':id_reuniao', $id_reuniao);
        $stmt->execute();

        header("Location: /servicedesk/reuniao_ata/reunioes/view.php?id=$id_reuniao");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
