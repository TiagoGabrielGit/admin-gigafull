<?php
require "../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $incidenteID = $_POST['incidenteID'];
    $caixaID = $_POST['caixaID'];

    // Insira os dados no banco de dados (certifique-se de validar e evitar SQL Injection)
    $sql = "INSERT INTO incidentes_ctos (incidente_id, cto_id, created_at) VALUES (:incidenteID, :caixaID, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':incidenteID', $incidenteID, PDO::PARAM_INT);
    $stmt->bindParam(':caixaID', $caixaID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Dados inseridos com sucesso
        echo 'Dados salvos com sucesso!';
    } else {
        // Erro ao salvar os dados
        echo 'Erro ao salvar os dados.';
    }
}
