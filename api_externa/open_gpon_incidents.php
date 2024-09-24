<?php
header("Content-Type: application/json; charset=UTF-8");

require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$id_api = 9;

$query_api = "SELECT active
FROM api
WHERE id = $id_api";

$query_api = $pdo->prepare($query_api);
$query_api->execute();
$result_api = $query_api->fetch(PDO::FETCH_ASSOC);

if ($result_api['active'] == 1) {

    $ip = $_SERVER['REMOTE_ADDR'];

    $query_ip = "SELECT count(*) as qtde
    FROM api_externa_ip
    WHERE api_id = $id_api and ip = :ip";

    $stmt_ip = $pdo->prepare($query_ip);
    $stmt_ip->bindParam(':ip', $ip, PDO::PARAM_STR);
    $stmt_ip->execute();
    $result_ip = $stmt_ip->fetchAll(PDO::FETCH_ASSOC);

    if ($result_ip[0]['qtde'] > 0) {

        if (!empty($_GET['token'])) {
            $token = $_GET['token'];

            $sql = "SELECT id FROM empresas WHERE token = :token";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $empresa_id = $result['id'];

                $sqlInteressados = "SELECT gpon_olt_id FROM gpon_olts_interessados WHERE interessado_empresa_id = :empresa_id AND active = 1";
                $stmtInteressados = $pdo->prepare($sqlInteressados);
                $stmtInteressados->bindParam(':empresa_id', $empresa_id);
                $stmtInteressados->execute();
                $olts = $stmtInteressados->fetchAll(PDO::FETCH_COLUMN);
                $olt_ids = implode(',', $olts);
                if ($olts) {

                    try {

                        $sql = "SELECT i.*
                    FROM incidentes as i 
                    LEFT JOIN gpon_pon as gp ON gp.id = i.pon_id
                    LEFT JOIN gpon_olts as go ON go.id = gp.olt_id
                    WHERE i.incident_type = 100 AND i.active = 1 AND go.id IN ($olt_ids)
                    ORDER BY i.id desc";
                        $stmt = $pdo->query($sql);
                        $incidentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

                        $incidentes = array_map(function ($incidente) use ($pdo) {
                            $incidente_id = $incidente['id'];

                            $sql_ctos =
                                "SELECT gc.id, gc.title, gc.lat, gc.lng, gc.patitle, gc.nbintegration_code, gc.paintegration_code
            FROM incidentes_ctos as ic
            LEFT JOIN gpon_ctos as gc ON ic.cto_id = gc.id
            WHERE ic.incidente_id = ?";
                            $stmt_ctos = $pdo->prepare($sql_ctos);
                            $stmt_ctos->execute([$incidente_id]);
                            $incidente['ctos_afetadas'] = $stmt_ctos->fetchAll(PDO::FETCH_ASSOC);

                            return $incidente;
                        }, $incidentes);

                        echo json_encode($incidentes);

                        $log = 'Execução bem sucedida';
                    } catch (PDOException $e) {
                        echo json_encode(array("error" => $e->getMessage()));

                        $log = 'Error não identifcado';
                    } finally {
                    }
                } else {
                    $log = "Nenhuma OLT interessada encontrada para esse token";
                    echo "Nenhuma OLT interessada encontrada para esse token";
                }
            } else {
                $log = "Token não encontrado";
                echo "Token não encontrado";
            }
        } else {
            $log = "Token não fornecido";
            echo "Token não fornecido";
        }
    } else {
        $log = "IP de origem não autorizado";
        echo "IP $ip não autorizado";
    }
    $sql_log = "INSERT INTO logs_apis_externas (api_id, log, ip_origem, data) 
    VALUES (:api_id, :log, :ip_origem, NOW())";
    $stmt_log = $pdo->prepare($sql_log);
    $stmt_log->bindParam(':api_id', $id_api, PDO::PARAM_INT);
    $stmt_log->bindParam(':log', $log, PDO::PARAM_STR);
    $stmt_log->bindParam(':ip_origem', $ip, PDO::PARAM_STR);
    $stmt_log->execute();

    $pdo = null;
} else {
    echo "API não habilitada";
}
