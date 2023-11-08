<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../../conexoes/conexao_pdo.php";
    $idMP = $_POST['idMP'];
    $titulo = $_POST['titulo'];
    $dataAgendamento = $_POST['dataAgendamento'];
    $duracao = $_POST['duracao'];
    $descricao = $_POST['descricao'];
    $responsavel_name = $_POST['responsavel_name'];
    $responsavel_contato = $_POST['responsavel_contato'];

    if (isset($_POST['acao'])) {
        $acao = $_POST['acao'];

        switch ($acao) {
            case "salvar_rascunho":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE manutencao_programada SET titulo = :titulo, dataAgendamento = :dataAgendamento, duracao = :duracao, descricao = :descricao, responsavel_name = :responsavel_name, responsavel_contato = :responsavel_contato,  active = 3 WHERE id = :idMP";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idMP', $idMP, PDO::PARAM_INT);
                    $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
                    $stmt->bindParam(':dataAgendamento', $dataAgendamento, PDO::PARAM_STR);
                    $stmt->bindParam(':duracao', $duracao, PDO::PARAM_INT);
                    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
                    $stmt->bindParam(':responsavel_name', $responsavel_name, PDO::PARAM_STR);
                    $stmt->bindParam(':responsavel_contato', $responsavel_contato, PDO::PARAM_STR);


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

                    $sql = "UPDATE manutencao_programada SET titulo = :titulo, dataAgendamento = :dataAgendamento, duracao = :duracao, descricao = :descricao, step = 2 WHERE id = :idMP";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idMP', $idMP, PDO::PARAM_INT);
                    $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR); // Suponha que 'titulo' seja uma string (VARCHAR)
                    $stmt->bindParam(':dataAgendamento', $dataAgendamento, PDO::PARAM_STR); // Suponha que 'dataAgendamento' seja uma string (VARCHAR) contendo uma data
                    $stmt->bindParam(':duracao', $duracao, PDO::PARAM_INT); // Se 'duracao' for um número inteiro
                    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR); // Suponha que 'descricao' seja uma string (TEXT ou VARCHAR)

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
