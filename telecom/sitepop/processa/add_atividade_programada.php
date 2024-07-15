<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    $pop_id = $_POST['atividade_popid'];
    $atividade_id = $_POST['atividade_atividade'];
    $date = $_POST['atividade_data_agendamento'];
    $status = "1";

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a instrução SQL de inserção
        $stmt = $pdo->prepare("INSERT INTO pop_atividade_programada (pop_id, atividade_id, date, status) VALUES (:pop_id, :atividade_id, :date, :status)");

        // Vincula os parâmetros da consulta aos valores
        $stmt->bindParam(':pop_id', $pop_id);
        $stmt->bindParam(':atividade_id', $atividade_id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':status', $status);

        // Executa a instrução SQL
        $stmt->execute();

        header("Location: /telecom/sitepop/view_atividades.php?id=" . $pop_id);
    } catch (PDOException $e) {
        header("Location: /telecom/sitepop/view_atividades.php?id=" . $pop_id);
    }

    $pdo = null;
}
