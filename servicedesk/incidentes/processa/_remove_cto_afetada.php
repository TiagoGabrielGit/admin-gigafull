<?php
require "../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $incidenteID = $_POST['incidenteID'];
    $caixaID = $_POST['caixaID'];

    if (!is_numeric($incidenteID) || !is_numeric($caixaID)) {
echo $incidenteID . "<br>";
echo $caixaID . "<br>";
        echo 'error'; // Responda com um erro se os dados não forem válidos
        exit;
    }

    // Execute a lógica para excluir o registro da tabela de caixas afetadas
    try {
        // Substitua 'sua_tabela_caixas_afetadas' pelo nome real da sua tabela
        $sql = "DELETE FROM incidentes_ctos WHERE incidente_id = :incidenteID AND cto_id = :caixaID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':incidenteID', $incidenteID, PDO::PARAM_INT);
        $stmt->bindParam(':caixaID', $caixaID, PDO::PARAM_INT);
        $stmt->execute();

        // Responda com sucesso se a exclusão for bem-sucedida
        echo 'success';
    } catch (PDOException $e) {
        // Responda com erro em caso de falha na exclusão
        echo 'error aqui';
    }
} else {
    // Responda com erro se o método de solicitação não for POST
    echo 'error';
}
?>
