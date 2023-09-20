<?php
session_start();
if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../../conexoes/conexao_pdo.php";

        $titulo = $_POST["titulo"];
        $dataAgendamento = $_POST["dataAgendamento"];
        $duracao = $_POST["duracao"];
        $descricao = $_POST["descricao"];
        $mensagem = $_POST["mensagem"];
        $active = "1";

        $query = "INSERT INTO manutencao_programada (titulo, dataAgendamento, duracao, descricao, mensagem, active) VALUES (:titulo, :dataAgendamento, :duracao, :descricao, :mensagem, :active)";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":titulo", $titulo);
            $stmt->bindParam(":dataAgendamento", $dataAgendamento);
            $stmt->bindParam(":duracao", $duracao);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":mensagem", $mensagem);
            $stmt->bindParam(":active", $active);
            $stmt->execute();

            $manutencao_id = $pdo->lastInsertId();

            if (!empty($_POST["rotasDeFibra"])) {
                $rotasDeFibra = $_POST["rotasDeFibra"];


                foreach ($rotasDeFibra as $rota) {
                    $queryRotasDeFibra = "INSERT INTO manutencao_rotas_fibra (manutencao_id, rota_id) VALUES (:manutencao_id, :rota_id)";

                    $stmtRotasDeFibra = $pdo->prepare($queryRotasDeFibra);
                    $stmtRotasDeFibra->bindParam(":manutencao_id", $manutencao_id);
                    $stmtRotasDeFibra->bindParam(":rota_id", $rota);
                    $stmtRotasDeFibra->execute();
                }
            }

            if (!empty($_POST["pons"])) {
                $pons = $_POST["pons"];

                foreach ($pons as $pon) {
                    $queryPons = "INSERT INTO manutencao_gpon (manutencao_id, pon_id) VALUES (:manutencao_id, :pon_id)";

                    $stmtPons = $pdo->prepare($queryPons);
                    $stmtPons->bindParam(":manutencao_id", $manutencao_id);
                    $stmtPons->bindParam(":pon_id", $pon);
                    $stmtPons->execute();
                }
            }

            header("Location: /servicedesk/manutencao_programada/manutencoes_programadas/view.php?id=$manutencao_id");
            exit();
        } catch (PDOException $e) {
            echo "Erro na inserção dos dados: " . $e->getMessage();
        }
    } else {
        header("Location: /servicedesk/manutencao_programada/agendar_manutencao/index.php");
        exit();
    }
}
