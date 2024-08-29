<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../../conexoes/conexao_pdo.php";

        $titulo = $_POST["tituloMP"];
        $dataAgendamento = $_POST["dataAgendamentoMP"];
        $duracao = $_POST["duracaoMP"];
        $status = $_POST["statusMP"];
        $descricao = $_POST["descricaoMP"];
        $mensagem = isset($_POST["mensagemMP"]) ? $_POST["mensagemMP"] : "";
        $id = $_POST["idMP"];

        try {
            // Query SQL de atualização
            $sql = "UPDATE manutencao_programada SET titulo = :titulo, dataAgendamento = :dataAgendamento, duracao = :duracao, active = :status, descricao = :descricao, mensagem = :mensagem WHERE id = :id";

            // Preparar a declaração PDO
            $stmt = $pdo->prepare($sql);

            // Bind dos parâmetros
            $stmt->bindParam(":titulo", $titulo);
            $stmt->bindParam(":dataAgendamento", $dataAgendamento);
            $stmt->bindParam(":duracao", $duracao);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":mensagem", $mensagem);
            $stmt->bindParam(":id", $id);

            // Executar a atualização
            if ($stmt->execute()) {
                header("Location: /servicedesk/manutencao_programada/manutencoes_programadas/view.php?id=$id");
                exit();
            } else {
                header("Location: /servicedesk/manutencao_programada/manutencoes_programadas/view.php?id=$id");
                exit();
            }
        } catch (PDOException $e) {
            // Erro na execução da consulta
            echo "Erro: " . $e->getMessage();
        }

        // Fechar a conexão com o banco de dados
        $pdo = null;
    }
}
