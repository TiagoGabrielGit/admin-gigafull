<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../../conexoes/conexao_pdo.php";

    $id = $_POST['idBateria'];
    $fabricanteId = $_POST['fabricante'];
    $modeloBateria = $_POST['modeloBateria'];
    $tensaoBateria = $_POST['tensaoBateria'];
    $amperagemBateria = $_POST['amperagemBateria'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    // Prepare a consulta SQL para atualizar a tabela produtos_bateria
    $sql = "UPDATE produtos_bateria SET fabricante_id = :fabricanteId, modelo = :modelo, tensao = :tensao, amperagem = :amperagem, active = :active WHERE id = :id";

    // Prepare a instrução SQL
    $stmt = $pdo->prepare($sql);

    // Execute a instrução SQL com os valores fornecidos
    $stmt->execute([
        'fabricanteId' => $fabricanteId,
        'modelo' => $modeloBateria,
        'tensao' => $tensaoBateria,
        'amperagem' => $amperagemBateria,
        'active' => $ativo,
        'id' => $id,
    ]);

    // Verifique se a atualização foi bem-sucedida
    if ($stmt->rowCount() > 0) {
        echo "A atualização foi realizada com sucesso!";
    } else {
        echo "Nenhum registro foi atualizado.";
    }
}
