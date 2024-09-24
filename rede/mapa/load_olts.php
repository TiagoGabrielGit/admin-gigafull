<?php
// Conexão com o banco de dados usando PDO
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Consulta OLTs
$stmt = $conn->query("SELECT id, olt_name FROM gpon_olts");
$olts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna as OLTs como JSON
echo json_encode($olts);
?>
