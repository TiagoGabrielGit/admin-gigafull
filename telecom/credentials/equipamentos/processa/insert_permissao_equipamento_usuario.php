<?php
session_start();
if ($_SESSION['id'] && $_SERVER["REQUEST_METHOD"] == "GET") {
    require "../../../../conexoes/conexao_pdo.php";
    try {

        $idUsuario = $_GET['idUsuario'];
        $idEquipamento = $_GET['idEquipamento'];

        // Preparar a instrução SQL
        $sql = "INSERT INTO equipamentos_pop_privacidade_usuario (equipamento_id, usuario_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);

        // Executar a instrução SQL com os valores correspondentes
        $stmt->execute([$idEquipamento, $idUsuario]);

    } catch (PDOException $e) {
        header("Location: /telecom/credentials/equipamentos/view.php?id=$idEquipamento");
        exit;
    }
}
