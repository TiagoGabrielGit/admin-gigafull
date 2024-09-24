<?php
header("Content-Type: application/json; charset=UTF-8");

require "../conexoes/conexao_pdo.php";

$query_api = "SELECT active
FROM api
WHERE id = 2";

$query_api = $pdo->prepare($query_api);
$query_api->execute();
$result_api = $query_api->fetch(PDO::FETCH_ASSOC);

if ($result_api['active'] == 1) {

    $ip = $_SERVER['REMOTE_ADDR'];

    $query_ip = "SELECT count(*) as qtde
    FROM api_externa_ip
    WHERE api_id = 2 and ip = :ip";

    $stmt_ip = $pdo->prepare($query_ip);
    $stmt_ip->bindParam(':ip', $ip, PDO::PARAM_STR);
    $stmt_ip->execute();
    $result_ip = $stmt_ip->fetchAll(PDO::FETCH_ASSOC);

    if ($result_ip[0]['qtde'] > 0) {


        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = "SELECT i.* , gp.cod_int
            FROM incidentes as i 
            LEFT JOIN gpon_pon as gp ON gp.id = i.pon_id
            WHERE i.incident_type = 100
            ORDER BY i.id desc
            LIMIT 100";
            $stmt = $pdo->query($sql);
            $incidentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $incidentes = array_map(function ($incidente) use ($pdo) {
                $id_incidente = $incidente['id'];
                $sql_relatos =
                    "SELECT ir.id, p.nome as usuario, LEFT(ir.relato, 100) as relato_limit_100_caracteres, ic.classificacao, ir.horarioRelato, ir.previsaoNormalizacao
                    FROM incidentes_relatos as ir
                    LEFT JOIN incidentes_classificacao as ic ON ic.id = ir.classificacao
                    LEFT JOIN usuarios as u ON u.id = ir.relato_autor
                    LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                    WHERE incidente_id = ?
                    ORDER BY ir.id desc";
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
        $log = "IP de origem não autorizado";
        echo "IP $ip não autorizado";
    }
    $sql_log = "INSERT INTO logs_apis_externas (api_id, log, ip_origem, data) 
    VALUES (:api_id, :log, :ip_origem, NOW())";
    $stmt_log = $pdo->prepare($sql_log);
    $stmt_log->bindParam(':api_id', $api_id, PDO::PARAM_INT);
    $stmt_log->bindParam(':log', $log, PDO::PARAM_STR);
    $stmt_log->bindParam(':ip_origem', $ip, PDO::PARAM_STR);
    $api_id = 2;
    $stmt_log->execute();

    $pdo = null;
} else {
    echo "API não habilitada";
}
