<?php
session_start();
if ($_SESSION['id'] && $_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../../conexoes/conexao_pdo.php";
    try {
        $idPermissaoEquipe = $_POST['idPermissaoEquipe'];

        // Preparar a instrução SQL
        $sql = "DELETE FROM equipamentos_pop_privacidade_equipe WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        // Executar a instrução SQL com o valor correspondente
        $stmt->execute([$idPermissaoEquipe]);

    } catch (PDOException $e) {

    }
}
