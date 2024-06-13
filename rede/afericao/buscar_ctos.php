<?php
// buscar_ctos.php

require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$term = $_GET['term'];
$olt_id = $_GET['olt_id'];

$query = "SELECT gc.title AS value, gc.id AS id_cto, gc.nbintegration_code AS integration_code
          FROM gpon_ctos AS gc 
          LEFT JOIN gpon_pon AS gp ON gp.cod_int = gc.paintegration_code
          WHERE gc.title LIKE :term AND gp.olt_id = :olt_id";

$stmt = $pdo->prepare($query);
$stmt->execute(array(':term' => '%' . $term . '%', ':olt_id' => $olt_id));

// Formatar os resultados para JSON
$results = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $results[] = array(
        'label' => $row['value'], // Texto exibido no autocomplete
        'value' => $row['value'], // Valor selecionado pelo usuário
        'id_cto' => $row['id_cto'], // ID do CTO associado ao valor
        'integration_code' => $row['integration_code'] // Código de integração associado ao valor
    );
}

// Retornar os resultados como JSON
echo json_encode($results);
?>
