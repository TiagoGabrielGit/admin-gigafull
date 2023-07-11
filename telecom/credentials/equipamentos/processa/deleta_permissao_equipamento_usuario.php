<?php
session_start();
if ($_SESSION['id'] && $_SERVER["REQUEST_METHOD"] == "GET") {
    require "../../../../conexoes/conexao_pdo.php";
    try {
        $idPermissaoUsuario = $_GET['idPermissaoUsuario'];

        // Preparar a instrução SQL
        $sql = "DELETE FROM equipamentos_pop_privacidade_usuario WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        // Executar a instrução SQL com o valor correspondente
        $stmt->execute([$idPermissaoUsuario]);

    } catch (PDOException $e) {
        header("Location: /telecom/credentials/equipamentos/view.php?id=$idEquipamento");
        exit;
    }
}
