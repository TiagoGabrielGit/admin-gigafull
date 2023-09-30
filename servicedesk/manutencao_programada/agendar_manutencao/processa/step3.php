<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../../conexoes/conexao_pdo.php";
    $idMP = $_POST['idMP'];

    if (isset($_POST['acao'])) {
        $acao = $_POST['acao'];

        switch ($acao) {
            case "salvar_rascunho":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE manutencao_programada SET active = 3 WHERE id = :idMP";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idMP', $idMP, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        header("Location: /servicedesk/manutencao_programada/manutencoes_programadas/index.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    echo "Erro ao atualizar o status: " . $e->getMessage();
                }
                break;

            case "avancar":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    if (!empty($_POST["rotasDeFibra"])) {
                        $rotasDeFibra = $_POST["rotasDeFibra"];

                        foreach ($rotasDeFibra as $rota) {
                            $queryRotasDeFibra = "INSERT INTO manutencao_rotas_fibra (manutencao_id, rota_id) VALUES (:manutencao_id, :rota_id)";

                            $stmtRotasDeFibra = $pdo->prepare($queryRotasDeFibra);
                            $stmtRotasDeFibra->bindParam(":manutencao_id", $idMP);
                            $stmtRotasDeFibra->bindParam(":rota_id", $rota);
                            $stmtRotasDeFibra->execute();
                        }
                    }

                    $sql = "UPDATE manutencao_programada SET step = 4 WHERE id = :idMP";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':idMP', $idMP, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        header("Location: /servicedesk/manutencao_programada/agendar_manutencao/index.php");
                        exit();
                        //$envia_notificacao = true;
                    } else {
                        header("Location: /servicedesk/manutencao_programada/agendar_manutencao/index.php");
                        exit();
                        //$envia_notificacao = false;
                    }
                } catch (PDOException $e) {
                    echo "Erro ao atualizar o status: " . $e->getMessage();
                }
                break;

            case "cancelar_agendamento":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE manutencao_programada SET active = 0 WHERE id = :idMP";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idMP', $idMP, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        header("Location: /servicedesk/manutencao_programada/manutencoes_programadas/index.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    echo "Erro ao atualizar o status: " . $e->getMessage();
                }
                break;

            default:
                break;
        }
    }
}
