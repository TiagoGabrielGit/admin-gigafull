<?php
session_start();
if ($_SESSION['id'] && $_SERVER["REQUEST_METHOD"] == "GET") {
    require "../../../../conexoes/conexao_pdo.php";
    try {

        $idUsuario = $_GET['idUsuario'];
        $idVM = $_GET['idVM'];

        // Preparar a instrução SQL
        $sql = "INSERT INTO vm_privacidade_usuario (vm_id, usuario_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);

        // Executar a instrução SQL com os valores correspondentes
        $stmt->execute([$idVM, $idUsuario]);
    } catch (PDOException $e) {
        header("Location: /telecom/credentials/equipamentos/view.php?id=$idEquipamento");
        exit;
    }
}
