<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../../conexoes/conexao_pdo.php";

    $patrimonio = $_POST['patrimonio'];

    // Prepara a consulta SQL para verificar se o patrimônio está em uso
    $query = "SELECT COUNT(*) AS count FROM produtos_transceiver_units WHERE patrimonio = :patrimonio";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':patrimonio', $patrimonio);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    $stmt->closeCursor();

    // Verifica se o patrimônio está em uso ou não
    if ($count > 0) {
        echo "em_uso";
    } else {
        echo "disponivel";
    }
}
