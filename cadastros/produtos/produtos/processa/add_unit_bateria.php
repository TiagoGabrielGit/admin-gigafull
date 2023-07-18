<?php
require "../../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bateriaID = $_POST['bateriaID'];
    $patrimonioBateria = $_POST['patrimonioBateria'];
    $nSerieBateria = $_POST['nSerieBateria'];

    try {
        $sql = "INSERT INTO produtos_bateria_units (produto_bateria_id, patrimonio, n_serie, active, created) VALUES (?, ?, ?, '1', NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$bateriaID, $patrimonioBateria, $nSerieBateria]);

        if ($stmt->rowCount() > 0) {
            header("Location: /cadastros/produtos/produtos/view_baterias.php?id=$bateriaID&tabBateria=units");
            exit;
        } else {
            header("Location: /cadastros/produtos/produtos/view_baterias.php?id=$bateriaID&tabBateria=units");
            exit;
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1062) {
            header("Location: /cadastros/produtos/produtos/view_baterias.php?id=$bateriaID&tabBateria=units&error=numero_serie_duplicado");
            exit;
        } else {
            // Outros erros de exceção podem ser tratados aqui
            echo "Ocorreu um erro durante a inserção: " . $e->getMessage();
        }
    }
}
