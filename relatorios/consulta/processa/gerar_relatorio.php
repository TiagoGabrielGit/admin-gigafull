<?php
require "../../../conexoes/conexao_pdo.php";

$consultaId = $_POST['consulta_id'];

// Buscar o SQL da consulta com base no $consultaId
$sql = "SELECT consulta_sql FROM consultas_sql WHERE id = :consultaId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':consultaId', $consultaId, PDO::PARAM_INT);
$stmt->execute();
$consultaSql = $stmt->fetchColumn();

if ($consultaSql) {
    // Executar a consulta SQL e obter os resultados
    $stmt = $pdo->query($consultaSql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        // Gerar o conteúdo do arquivo CSV
        $csvContent = '';

        // Cabeçalhos do CSV (usando os nomes das colunas dos resultados)
        $colunas = array_keys($resultados[0]);
        $csvContent .= implode(',', $colunas) . "\n";

        // Dados do CSV
        foreach ($resultados as $linha) {
            $csvContent .= implode(',', $linha) . "\n";
        }

        // Definir cabeçalhos para iniciar o download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="relatorio.csv"');

        // Imprimir o conteúdo do arquivo CSV para a saída
        echo $csvContent;
    } else {
        echo 'error'; // Não há resultados para a consulta
    }
} else {
    echo 'error'; // Consulta não encontrada
}
