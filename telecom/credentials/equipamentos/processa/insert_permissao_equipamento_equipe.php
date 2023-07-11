<?php
session_start();
if ($_SESSION['id'] && $_SERVER["REQUEST_METHOD"] == "GET") {
    require "../../../../conexoes/conexao_pdo.php";
    try {

        $idEquipe = $_GET['idEquipe'];
        $idEquipamento = $_GET['idEquipamento'];

        // Preparar a instrução SQL
        $sql = "INSERT INTO equipamentos_pop_privacidade_equipe (equipamento_id, equipe_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);

        // Executar a instrução SQL com os valores correspondentes
        $stmt->execute([$idEquipamento, $idEquipe]);

        // Verificar se o INSERT foi realizado com sucesso
        if ($stmt->rowCount() > 0) {
            header("Location: /telecom/credentials/equipamentos/view.php?id=$idEquipamento");
            exit;
        } else {
            header("Location: /telecom/credentials/equipamentos/view.php?id=$idEquipamento");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: /telecom/credentials/equipamentos/view.php?id=$idEquipamento");
        exit;
    }
}
