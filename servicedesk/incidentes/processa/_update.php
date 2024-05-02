<?php
require "../../../conexoes/conexao_pdo.php";

$incidenteID = isset($_POST['incidenteID']) ? $_POST['incidenteID'] : null;
$solicitante = isset($_POST['solicitante']) ? $_POST['solicitante'] : null;
$classIncidente = isset($_POST['classIncidente']) ? $_POST['classIncidente'] : null;
$statusIncidente = isset($_POST['statusIncidente']) ? $_POST['statusIncidente'] : null;
$previsaoConclusao = isset($_POST['previsaoConclusao']) ? $_POST['previsaoConclusao'] : null;
$tipoIncidente = isset($_POST['tipoIncidente']) ? $_POST['tipoIncidente'] : null;
$relatoIncidente = isset($_POST['relatoIncidente']) ? $_POST['relatoIncidente'] : null;
$zabbixEventID = isset($_POST['zabbixEventID']) ? $_POST['zabbixEventID'] : null;
$protocoloERP = isset($_POST['protocoloERP']) ? $_POST['protocoloERP'] : null;
$comunicarInteressados = $_POST['comunicarInteressados'];
$descIncidente = $_POST['descIncidente'];

$horaAtual = date('Y-m-d H:i:s');

if ($classIncidente != NULL || $statusIncidente != NULL || $tipoIncidente != NULL || $previsaoConclusao != NULL || $descIncidente != NULL) {

    $sql = "UPDATE incidentes SET ";
    $params = array();

    if ($classIncidente != null) {
        $sql .= "classificacao = :classIncidente, ";
        $params[':classIncidente'] = $classIncidente;
    }

    if ($tipoIncidente != null) {
        $sql .= "incident_type = :tipoIncidente, ";
        $params[':tipoIncidente'] = $tipoIncidente;
    }

    if ($protocoloERP != null) {
        $sql .= "protocolo_erp = :protocoloERP, ";
        $params[':protocoloERP'] = $protocoloERP;
    }

    if ($descIncidente != null) {
        $sql .= "descricaoIncidente = :descricaoIncidente, ";
        $params[':descricaoIncidente'] = $descIncidente;
    }

    if ($statusIncidente != null && $statusIncidente == "0") {
        $sql .= "active = :statusIncidente, ";
        $params[':statusIncidente'] = $statusIncidente;

        $sql .= "fimIncidente = :fimIncidente, ";
        $params[':fimIncidente'] = $horaAtual;
    } else if (($statusIncidente != null && $statusIncidente == "1")) {
        $sql .= "active = :statusIncidente, ";
        $params[':statusIncidente'] = $statusIncidente;
    }

    if (isset($_POST['semPrevisao'])) {
        $previsaoConclusao = null;
        $sql .= "previsaoNormalizacao = :previsaoConclusao, ";
        $params[':previsaoConclusao'] = $previsaoConclusao;
    } else {
        if ($previsaoConclusao != null) {
            $sql .= "previsaoNormalizacao = :previsaoConclusao, ";
            $params[':previsaoConclusao'] = $previsaoConclusao;
        }
    }

    $sql .= "envio_com_normalizacao = :envio_com_normalizacao, ";
    $params[':envio_com_normalizacao'] = '0';

    $sql = rtrim($sql, ", ") . " WHERE id = :id";
    $params[':id'] = $incidenteID;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
}
$sql2 = "INSERT INTO incidentes_relatos (incidente_id, relato_autor, relato, horarioRelato, classificacao, previsaoNormalizacao) VALUES (:valor1, :valor4, :valor2, :valor3, :classificacao, :previsaoNormalizacao)";
$stmt2 = $pdo->prepare($sql2);

$stmt2->bindValue(':valor1', $incidenteID);
$stmt2->bindValue(':valor2', $relatoIncidente);
$stmt2->bindValue(':valor3', $horaAtual);
$stmt2->bindValue(':valor4', $solicitante);
$stmt2->bindValue(':classificacao', $classIncidente);
if (isset($_POST['semPrevisao'])) {
    $previsaoConclusao = null;
    $stmt2->bindValue(':previsaoNormalizacao', $previsaoConclusao);
} else {
    if ($previsaoConclusao != null) {
        $stmt2->bindValue(':previsaoNormalizacao', $previsaoConclusao);
    } else {
        $previsaoConclusao = null;
        $stmt2->bindValue(':previsaoNormalizacao', $previsaoConclusao);
    }
}



$stmt2->bindValue(':previsaoNormalizacao', $previsaoConclusao);

if ($stmt2->execute()) {
    if ($zabbixEventID == null) {
        if ($comunicarInteressados == 1) {
            header("Location: comunicaInteressados.php?incidenteID=$incidenteID");
            exit();
        } else {
            header("Location: /servicedesk/incidentes/view.php?id=$incidenteID");
            exit();
        }
    } else {
        $integracao_zabbix =
            "SELECT
            iz.id as id,
            iz.tokenAPI as tokenAPI,
            iz.statusIntegracao as statusIntegracao,
            iz.urlZabbix as urlZabbix
            FROM
            integracao_zabbix as iz
            WHERE
            iz.id = 1
            ";

        $r_integracao_zabbix = $pdo->query($integracao_zabbix);
        $c_integracao_zabbix = $r_integracao_zabbix->fetch(PDO::FETCH_ASSOC);

        if ($c_integracao_zabbix['statusIntegracao'] == 1) {
            $api_url = $c_integracao_zabbix['urlZabbix'];
            $tokenZabbix = $c_integracao_zabbix['tokenAPI'];

            $api_data = array(
                "jsonrpc" => "2.0",
                "method" => "event.acknowledge",
                "params" => array(
                    "eventids" => "$zabbixEventID",
                    "action" => 6,
                    "message" => "$relatoIncidente"
                ),
                "auth" => "$tokenZabbix",
                "id" => 1
            );

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($api_data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json-rpc',
            ));

            $api_response = curl_exec($ch);
            curl_close($ch);
            if ($comunicarInteressados == 1) {
                header("Location: comunicaInteressados.php?incidenteID=$incidenteID");
                exit();
            } else {
                header("Location: /servicedesk/incidentes/view.php?id=$incidenteID");
                exit();
            }
        } else {
            if ($comunicarInteressados == 1) {
                header("Location: comunicaInteressados.php?incidenteID=$incidenteID");
                exit();
            } else {
                header("Location: /servicedesk/incidentes/view.php?id=$incidenteID");
                exit();
            }
        }
    }
} else {
    header("Location: /servicedesk/incidentes/view.php?id=$incidenteID");
    exit();
}
