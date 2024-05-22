<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$query_api = "SELECT active
FROM api
WHERE id = 4";

$query_api = $pdo->prepare($query_api);
$query_api->execute();
$result_api = $query_api->fetch(PDO::FETCH_ASSOC);

if ($result_api['active'] == 1) {

    $ip = $_SERVER['REMOTE_ADDR'];

    $query_ip = "SELECT count(*) as qtde
    FROM api_externa_ip
    WHERE api_id = 4 and ip = :ip";

    $stmt_ip = $pdo->prepare($query_ip);
    $stmt_ip->bindParam(':ip', $ip, PDO::PARAM_STR);
    $stmt_ip->execute();
    $result_ip = $stmt_ip->fetchAll(PDO::FETCH_ASSOC);

    if ($result_ip[0]['qtde'] > 0) {

        $descricaoIncidente = $_GET["descricaoIncidente"];
        $zabbixEventID = $_GET["eventID"];
        $incidentType =  $_GET["incidentType"];
        $classificacao = "0";
        $hostID =  $_GET["hostID"];
        $zabbix_id = isset($_GET["zabbix_id"]) ? $_GET["zabbix_id"] : '';

        $captura_vendor_olt = "SELECT f.fabricante as vendor
        FROM gpon_olts as go 
        LEFT JOIN equipamentospop as epop ON epop.id = go.equipamento_id
        LEFT JOIN equipamentos as e ON e.id = epop.equipamento_id
        LEFT JOIN fabricante as f ON f.id = e.fabricante
        WHERE go.equipamento_id = :hostID";

        $stmt_captura_vendor_olt = $pdo->prepare($captura_vendor_olt);
        $stmt_captura_vendor_olt->bindParam(':hostID', $hostID);
        $stmt_captura_vendor_olt->execute();
        $captura_vendor_olt_row = $stmt_captura_vendor_olt->fetch(PDO::FETCH_ASSOC);

        if ($captura_vendor_olt_row) {
            if ($captura_vendor_olt_row['vendor'] == 'Huawei') {
                $gponPON = isset($_GET["gponPON"]) ? $_GET["gponPON"] : '';
                $gponParts = explode("/", $gponPON);
                $gpon_slot = isset($gponParts[1]) ? $gponParts[1] : '';
                $gpon_pon = isset($gponParts[2]) ? $gponParts[2] : '';

                $cap_id_pon_query = "SELECT gpp.id
                FROM gpon_pon AS gpp
                LEFT JOIN gpon_olts AS gpo ON gpo.id = gpp.olt_id
                WHERE gpp.slot = :gpon_slot
                AND gpp.pon = :gpon_pon
                AND gpo.equipamento_id = :hostID";

                $stmt_cap_id_pon = $pdo->prepare($cap_id_pon_query);
                $stmt_cap_id_pon->bindParam(':gpon_slot', $gpon_slot);
                $stmt_cap_id_pon->bindParam(':gpon_pon', $gpon_pon);
                $stmt_cap_id_pon->bindParam(':hostID', $hostID);
                $stmt_cap_id_pon->execute();
                $pon_id_row = $stmt_cap_id_pon->fetch(PDO::FETCH_ASSOC);

                if ($pon_id_row) {
                    $pon_id = $pon_id_row['id'];
                } else {
                    $pon_id = "";
                }
            } else if ($captura_vendor_olt_row['vendor'] == 'Raisecon') {
                $gponPON = isset($_GET["gponPON"]) ? $_GET["gponPON"] : '';
                // Usando uma expressão regular para extrair os valores
                preg_match('/gpon-olt(\d+)\/(\d+)/', $gponPON, $matches);

                $gpon_slot = $matches[1];
                $gpon_pon = $matches[2];
                $cap_id_pon_query = "SELECT gpp.id
                FROM gpon_pon AS gpp
                LEFT JOIN gpon_olts AS gpo ON gpo.id = gpp.olt_id
                WHERE gpp.slot = :gpon_slot
                AND gpp.pon = :gpon_pon
                AND gpo.equipamento_id = :hostID";

                $stmt_cap_id_pon = $pdo->prepare($cap_id_pon_query);
                $stmt_cap_id_pon->bindParam(':gpon_slot', $gpon_slot);
                $stmt_cap_id_pon->bindParam(':gpon_pon', $gpon_pon);
                $stmt_cap_id_pon->bindParam(':hostID', $hostID);
                $stmt_cap_id_pon->execute();
                $pon_id_row = $stmt_cap_id_pon->fetch(PDO::FETCH_ASSOC);

                if ($pon_id_row) {
                    $pon_id = $pon_id_row['id'];
                } else {
                    $pon_id = "";
                }
            } else {
                $gpon_slot = "";
                $gpon_pon = "";
                $pon_id = "";
            }

            $sql_new_incidente =
                "INSERT INTO incidentes (zabbix_id, zabbix_event_id, equipamento_id, descricaoIncidente, classificacao, inicioIncidente, active, incident_type, gpon_slot, gpon_pon, pon_id, envio_com_normalizacao)
                VALUES (:zabbix_id, :zabbix_event_id, :equipamento_id, :descricaoIncidente,:classificacao, NOW(), '1', :incidentType, :gpon_slot, :gpon_pon, :pon_id, '0')";
            $stmt = $pdo->prepare($sql_new_incidente);
            $stmt->bindParam(':zabbix_id', $zabbix_id);

            $stmt->bindParam(':equipamento_id', $hostID);
            $stmt->bindParam(':descricaoIncidente', $descricaoIncidente);
            $stmt->bindParam(':zabbix_event_id', $zabbixEventID);
            $stmt->bindParam(':classificacao', $classificacao);
            $stmt->bindParam(':incidentType', $incidentType);
            $stmt->bindParam(':gpon_slot', $gpon_slot);
            $stmt->bindParam(':gpon_pon', $gpon_pon);
            $stmt->bindParam(':pon_id', $pon_id);
            if ($stmt->execute()) {
                $response['ID do Incidente'] = $pdo->lastInsertId();
                $response['Retorno da Chamada'] = "Incidente Aberto";
            } else {
                $response['Retorno da Chamada'] = "Falha ao abrir incidente";
            }
        } else {
            $response['Retorno da Chamada'] = "Equipamento/Vendor id $hostID não encontrado";
        }
        echo json_encode($response);
    } else {
        echo "IP $ip não autorizado";
    }
} else {
    echo "API não habilitada";
}
