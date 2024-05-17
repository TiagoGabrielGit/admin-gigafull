<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    $criador = $_SESSION['id'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $assunto = $_POST["assunto"];
            $inicio = $_POST["inicio"];
            $fim = $_POST["fim"];
            $local = $_POST["local"];

            $pdo->beginTransaction();

            $sql_reuniao = "INSERT INTO ata_reuniao (assunto, inicio, fim, local, criador, status) VALUES (:assunto, :inicio, :fim, :local, :criador, 1)";
            $stmt_reuniao = $pdo->prepare($sql_reuniao);
            $stmt_reuniao->bindParam(':assunto', $assunto);
            $stmt_reuniao->bindParam(':inicio', $inicio);
            $stmt_reuniao->bindParam(':fim', $fim);
            $stmt_reuniao->bindParam(':local', $local);
            $stmt_reuniao->bindParam(':criador', $criador);

            $stmt_reuniao->execute();

            $id_ata_reuniao = $pdo->lastInsertId();

            if (isset($_POST['pauta']) && is_array($_POST['pauta'])) {
                $sql_pauta = "INSERT INTO ata_reuniao_pautas (id_ata_reuniao, pauta, descricao) VALUES (:id_ata_reuniao, :pauta, :descricao)";
                $stmt_pauta = $pdo->prepare($sql_pauta);
                $stmt_pauta->bindParam(':id_ata_reuniao', $id_ata_reuniao);
            
                foreach ($_POST['pauta'] as $indice => $pauta) {
                    $descricao = $_POST['descricaoPauta'][$indice];
            
                    $stmt_pauta->bindParam(':pauta', $pauta);
                    $stmt_pauta->bindParam(':descricao', $descricao);
            
                    $stmt_pauta->execute();
                }
            }
            


            if (
                isset($_POST['nomeParticipante']) && isset($_POST['emailParticipante']) &&
                is_array($_POST['nomeParticipante']) && is_array($_POST['emailParticipante']) &&
                !empty($_POST['nomeParticipante']) && !empty($_POST['emailParticipante'])
            ) {

                $sql_participante = "INSERT INTO ata_reuniao_participantes (id_ata_reuniao, nome, email) VALUES (:id_ata_reuniao, :nomeParticipante, :emailParticipante)";
                $stmt_participante = $pdo->prepare($sql_participante);
                $stmt_participante->bindParam(':id_ata_reuniao', $id_ata_reuniao);
                $stmt_participante->bindParam(':nomeParticipante', $nomeParticipante);
                $stmt_participante->bindParam(':emailParticipante', $emailParticipante);

                foreach ($_POST['nomeParticipante'] as $indice => $nomeParticipante) {
                    if (isset($_POST['emailParticipante'][$indice])) {
                        $emailParticipante = $_POST['emailParticipante'][$indice];
                        $stmt_participante->execute();
                    } else {
                        echo "Erro: O e-mail do participante não foi encontrado para o nome: $nomeParticipante";
                    }
                }
            }

            $pdo->commit();
            header("Location: /servicedesk/reuniao_ata/reunioes/view.php?id=$id_ata_reuniao");
            exit();
        } catch (PDOException $e) {
            $pdo->rollback();
            echo "Erro ao salvar ata de reunião: " . $e->getMessage();
        }

        $pdo = null;
    }
} else {
    header("Location: /index.php");
    exit();
}
