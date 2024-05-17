<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['nomeParticipante']) && isset($_POST['emailParticipante'])) {
            $id_reuniao = $_POST['id_reuniao'];

            $stmt = $pdo->prepare("INSERT INTO ata_reuniao_participantes (id_ata_reuniao, nome, email) VALUES (:id_ata_reuniao, :nome, :email)");

            foreach ($_POST['nomeParticipante'] as $index => $nomeParticipante) {
                if (isset($_POST['emailParticipante'][$index])) {
                    $stmt->bindParam(':nome', $_POST['nomeParticipante'][$index]);
                    $stmt->bindParam(':email', $_POST['emailParticipante'][$index]);
                    $stmt->bindParam(':id_ata_reuniao', $id_reuniao);

                    $stmt->execute();
                }
            }

            header("Location: /servicedesk/reuniao_ata/reunioes/view.php?id=$id_reuniao");
            exit();
        } else {
            header("Location: /servicedesk/reuniao_ata/reunioes/view.php?id=$id_reuniao");
            exit();        }
    } else {
        header("Location: /servicedesk/reuniao_ata/reunioes/view.php?id=$id_reuniao");
        exit();    }
} else {
    header("Location: /index.php");
    exit();
}
