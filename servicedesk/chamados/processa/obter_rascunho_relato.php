<?php
session_start();
if (isset($_SESSION['id'])) {
    if (isset($_POST['idChamado'])) {
        require "../../../conexoes/conexao_pdo.php";

        $idChamado = $_POST['idChamado'];
        $query = "SELECT relato FROM chamados_relatos_rascunho WHERE id_chamado = :idChamado ORDER BY id desc LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idChamado', $idChamado, PDO::PARAM_INT);
        $stmt->execute();

        // Se houver um resultado, retorne o rascunho do relato, caso contrário, retorne uma string vazia
        $rascunho = $stmt->fetchColumn();
        echo $rascunho ? $rascunho : '';
    } else {
        // Se o ID do chamado não foi fornecido, retorne uma string vazia
        echo '';
    }
} else {
    header("Location: /index.php");
    exit();
}
