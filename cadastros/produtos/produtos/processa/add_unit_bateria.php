<?php
require "../../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bateriaID = $_POST['bateriaID'];
    $patrimonioBateria = $_POST['patrimonioBateria'];
    $nSerieBateria = $_POST['nSerieBateria'];

    $sql = "INSERT INTO produtos_bateria_units (produto_bateria_id, patrimonio, n_serie, active, created, disponibilidade) VALUES (?, ?, ?, '1', NOW(), '1')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$bateriaID, $patrimonioBateria, $nSerieBateria]);

    // Verifica se o registro foi inserido com sucesso
    if ($stmt->rowCount() > 0) {
        $id = $pdo->lastInsertId(); // Obtém o último ID inserido
        header("Location: /cadastros/produtos/produtos/view_baterias.php?id=$bateriaID");
        exit;
    } else {
        header("Location: /cadastros/produtos/produtos/view_baterias.php?id=$bateriaID");
        exit;
    }
}
