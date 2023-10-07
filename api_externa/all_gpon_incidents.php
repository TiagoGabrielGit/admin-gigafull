<?php
header("Content-Type: application/json; charset=UTF-8");

// Adicione um cabeçalho CORS, se necessário
// header("Access-Control-Allow-Origin: *");

require "../conexoes/conexao_pdo.php";

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT i.* , gp.cod_int
    FROM incidentes as i 
    LEFT JOIN gpon_pon as gp ON gp.id = i.pon_id
    WHERE i.incident_type = 100 AND i.id = 10004 
    LIMIT 100";
    $stmt = $pdo->query($sql);
    $incidentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $incidentes = array_map(function ($incidente) use ($pdo) {
        $id_incidente = $incidente['id'];
        $sql_relatos =
            "SELECT ic.classificacao, ir.horarioRelato, ir.previsaoNormalizacao
        FROM incidentes_relatos as ir
        LEFT JOIN incidentes_classificacao as ic ON ic.id = ir.classificacao
        WHERE incidente_id = ?";
        $stmt_relatos = $pdo->prepare($sql_relatos);
        $stmt_relatos->execute([$id_incidente]);
        $incidente['historico'] = $stmt_relatos->fetchAll(PDO::FETCH_ASSOC);

        return $incidente;
    }, $incidentes);

    $incidentes = array_map(function ($incidente) use ($pdo) {
        $pon_id = $incidente['pon_id'];

        $sql_localidades =
            "SELECT *
            FROM gpon_localidades as gl
            WHERE gl.pon_id = ?";
        $stmt_relatos = $pdo->prepare($sql_localidades);
        $stmt_relatos->execute([$pon_id]);
        $incidente['localidades'] = $stmt_relatos->fetchAll(PDO::FETCH_ASSOC);

        return $incidente;
    }, $incidentes);

    echo json_encode($incidentes);
} catch (PDOException $e) {
    echo json_encode(array("error" => $e->getMessage()));
} finally {
    // Feche a conexão PDO
    $pdo = null;
}
