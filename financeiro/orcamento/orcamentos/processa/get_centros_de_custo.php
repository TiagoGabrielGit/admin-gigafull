<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Verificar se o agrupamento_id foi passado via GET
    if (isset($_GET['agrupamento_id'])) {
        $agrupamento_id = intval($_GET['agrupamento_id']);

        // Consultar os centros de custo com base no agrupamento_id
        $sql = "SELECT id, centro_de_custo AS nome FROM cc_centro_de_custo WHERE agrupamento_id = :agrupamento_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':agrupamento_id', $agrupamento_id, PDO::PARAM_INT);
        $stmt->execute();

        $centros_de_custo = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retornar os dados em formato JSON
        echo json_encode($centros_de_custo);
    } else {
        echo json_encode([]);
    }
}
