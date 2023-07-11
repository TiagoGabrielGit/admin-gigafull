<?php
session_start();
if ($_SESSION['id'] && $_SERVER["REQUEST_METHOD"] == "GET") {
    require "../../../../conexoes/conexao_pdo.php";
    try {

        $idEquipe = $_GET['idEquipe'];
        $idVM = $_GET['idVM'];

        // Preparar a instrução SQL
        $sql = "INSERT INTO vm_privacidade_equipe (vm_id, equipe_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);

        // Executar a instrução SQL com os valores correspondentes
        $stmt->execute([$idVM, $idEquipe]);
    } catch (PDOException $e) {
        header("Location: /telecom/credentials/equipamentos/view.php?id=$idVM");
        exit;
    }
}
