<?php
header("Content-Type: application/json; charset=UTF-8");
require "../conexoes/conexao_pdo.php";
try {
    // Configuração para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta incidentes abertos
    $sql = "SELECT * FROM incidentes WHERE active = 1";
    $stmt = $pdo->query($sql);

    // Obtém os resultados como um array associativo
    $incidentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Codifica os resultados em JSON e imprime
    echo json_encode($incidentes);
} catch (PDOException $e) {
    // Em caso de erro na conexão ou consulta
    echo json_encode(array("error" => $e->getMessage()));
}

// Fecha a conexão com o banco de dados
$conn = null;
