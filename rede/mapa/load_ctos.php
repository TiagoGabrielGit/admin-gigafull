<?php
// Verifica se 'pon_ids' está presente e não vazio
if (isset($_POST['pon_ids']) && !empty($_POST['pon_ids'])) {
    $pon_ids = $_POST['pon_ids'];

    // Caso seja uma string separada por vírgulas, converte para array
    if (!is_array($pon_ids)) {
        $pon_ids = explode(',', $pon_ids);
    }

    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Consulta CTOs relacionadas às PONs selecionadas
    $query = "SELECT id, title, lat, lng FROM gpon_ctos WHERE paintegration_code IN (" . implode(',', array_map('intval', $pon_ids)) . ")";
    $stmt = $pdo->query($query);
    $ctos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna as CTOs como JSON
    echo json_encode($ctos);
} else {
    // Se 'pon_ids' não for enviado ou estiver vazio, retorna uma resposta vazia ou erro
    echo json_encode([]);
}
?>
