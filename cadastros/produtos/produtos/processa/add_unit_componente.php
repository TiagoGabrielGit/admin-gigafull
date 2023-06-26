<?php
require "../../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $componenteID = $_POST['componenteID'];
    $patrimonioComponente = $_POST['patrimonioComponente'];
    $nSerieComponente = $_POST['nSerieComponente'];

    $sql = "INSERT INTO produtos_componente_units (produto_componente_id, patrimonio, n_serie, active, created, disponibilidade) VALUES (?, ?, ?, '1', NOW(), '1')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$componenteID, $patrimonioComponente, $nSerieComponente]);

    // Verifica se o registro foi inserido com sucesso
    if ($stmt->rowCount() > 0) {
        $id = $pdo->lastInsertId(); // Obtém o último ID inserido
        header("Location: /cadastros/produtos/produtos/view_componentes.php?id=$componenteID");
        exit;
    } else {
        header("Location: /cadastros/produtos/produtos/view_componentes.php?id=$componenteID");
        exit;
    }
}
