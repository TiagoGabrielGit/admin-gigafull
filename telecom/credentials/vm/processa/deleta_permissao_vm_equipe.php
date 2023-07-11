<?php
session_start();
if ($_SESSION['id'] && $_SERVER["REQUEST_METHOD"] == "GET") {
    require "../../../../conexoes/conexao_pdo.php";
    try {
        $idPermissaoEquipe = $_GET['idPermissaoEquipe'];

        // Preparar a instrução SQL
        $sql = "DELETE FROM vm_privacidade_equipe WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        // Executar a instrução SQL com o valor correspondente
        $stmt->execute([$idPermissaoEquipe]);

    } catch (PDOException $e) {
        header("Location: /telecom/credentials/equipamentos/view.php?id=$idEquipamento");
        exit;
    }
}
