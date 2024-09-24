<?php
// Verifica se 'olt_ids' está presente e não vazio
if (isset($_POST['olt_ids']) && !empty($_POST['olt_ids'])) {
    $olt_ids = $_POST['olt_ids'];

    // Caso seja uma string separada por vírgulas, converte para array
    if (!is_array($olt_ids)) {
        $olt_ids = explode(',', $olt_ids);
    }

    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Consulta PONs relacionadas às OLTs selecionadas
    $query = "SELECT cod_int as id, slot, pon FROM gpon_pon WHERE olt_id IN (" . implode(',', array_map('intval', $olt_ids)) . ")";
    $stmt = $pdo->query($query);
    $pons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna as PONs como JSON
    echo json_encode($pons);
} else {
    // Se 'olt_ids' não for enviado ou estiver vazio, retorna uma resposta vazia ou erro
    echo json_encode([]);
}
?>
