<?php
session_start();

if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['ap_id']) && isset($_POST['ap_status'])) {
        require "../../../conexoes/conexao_pdo.php";

        $ap_id = $_POST['ap_id'];
        $ap_status = $_POST['ap_status'];
        $ap_pop_id = $_POST['ap_pop_id'];

        try {
            $stmt = $pdo->prepare("UPDATE pop_atividade_programada SET status = :status WHERE id = :id");

            // Vincula os parâmetros da consulta aos valores
            $stmt->bindParam(':status', $ap_status);
            $stmt->bindParam(':id', $ap_id);

            // Executa a instrução SQL
            $stmt->execute();

            // Redireciona para a página de visualização
            header("Location: /telecom/sitepop/view_atividades.php?id=$ap_pop_id");
            exit;
        } catch (PDOException $e) {
            header("Location: /telecom/sitepop/view_atividades.php?id=$ap_pop_id");
        }
    } else {
        header("Location: /telecom/sitepop/view_atividades.php?id=$ap_pop_id");
    }
} else {
    header("Location: /telecom/sitepop/view_atividades.php?id=$ap_pop_id");
}
