<?php
session_start();

if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['mc_id']) && isset($_POST['mc_status'])) {
        require "../../../conexoes/conexao_pdo.php";

        $mc_id = $_POST['mc_id'];
        $mc_status = $_POST['mc_status'];
        $mc_pop_id = $_POST['mc_pop_id'];

        try {
            $stmt = $pdo->prepare("UPDATE pop_melhorias_conhecidas SET status = :status WHERE id = :id");

            // Vincula os parâmetros da consulta aos valores
            $stmt->bindParam(':status', $mc_status);
            $stmt->bindParam(':id', $mc_id);

            // Executa a instrução SQL
            $stmt->execute();

            // Redireciona para a página de visualização
            header("Location: /telecom/sitepop/view_atividades.php?id=$mc_pop_id&tab=atividades");
            exit;
        } catch (PDOException $e) {
            header("Location: /telecom/sitepop/view_atividades.php?id=$mc_pop_id&tab=atividades");
        }
    } else {
        header("Location: /telecom/sitepop/view_atividades.php?id=$mc_pop_id&tab=atividades");
    }
} else {
    header("Location: /telecom/sitepop/view_atividades.php?id=$mc_pop_id&tab=atividades");
}
