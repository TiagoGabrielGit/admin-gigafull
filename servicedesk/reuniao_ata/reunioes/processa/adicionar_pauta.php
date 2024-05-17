<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['pauta']) && isset($_POST['descricaoPauta'])) {
            $stmt = $pdo->prepare("INSERT INTO ata_reuniao_pautas (id_ata_reuniao, pauta, descricao) VALUES (:id_reuniao, :pauta, :descricao)");
            $id_reuniao = $_POST['id_reuniao'];
            foreach ($_POST['pauta'] as $index => $pauta) {
                if (isset($_POST['descricaoPauta'][$index])) {
                    $stmt->bindParam(':id_reuniao', $id_reuniao);
                    $stmt->bindParam(':pauta', $_POST['pauta'][$index]);
                    $stmt->bindParam(':descricao', $_POST['descricaoPauta'][$index]);
                    $stmt->execute();
                }
            }
            header("Location: /servicedesk/reuniao_ata/reunioes/view.php?id=$id_reuniao");
            exit();
        } else {
            header("Location: /servicedesk/reuniao_ata/reunioes/view.php?id=$id_reuniao");
            exit();
        }
    } else {
        header("Location: /servicedesk/reuniao_ata/reunioes/view.php?id=$id_reuniao");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
