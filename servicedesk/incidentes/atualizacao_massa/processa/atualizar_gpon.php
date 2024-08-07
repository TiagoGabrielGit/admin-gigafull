<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['checkboxes']) && is_array($_POST['checkboxes'])) {
            require "../../../../conexoes/conexao_pdo.php";

            $integracao_zabbix =
                "SELECT iz.id as id, iz.tokenAPI as tokenAPI, iz.statusIntegracao as statusIntegracao, iz.urlZabbix as urlZabbix
                FROM integracao_zabbix as iz WHERE iz.id = 1";

            $r_integracao_zabbix = $pdo->query($integracao_zabbix);
            $c_integracao_zabbix = $r_integracao_zabbix->fetch(PDO::FETCH_ASSOC);

            $solicitante = isset($_POST['solicitante']) ? $_POST['solicitante'] : null; //OK
            $classIncidente = isset($_POST['classIncidente']) ? $_POST['classIncidente'] : null; //OK
            $statusIncidente = isset($_POST['statusIncidente']) ? $_POST['statusIncidente'] : null; //OK
            $previsaoConclusao = isset($_POST['previsaoConclusao']) ? $_POST['previsaoConclusao'] : null; //OK
            $relatoIncidente = isset($_POST['relatoIncidente']) ? $_POST['relatoIncidente'] : null; //OK
            $protocoloERP = isset($_POST['protocoloERP']) ? $_POST['protocoloERP'] : null; //OK
            $descEvento = $_POST['descEvento']; //OK

            $horaAtual = date('Y-m-d H:i:s');

            foreach ($_POST['checkboxes'] as $incidente_id) {
                if ($classIncidente != NULL || $statusIncidente != NULL || $previsaoConclusao != NULL || $descEvento != NULL) {

                    $sql = "UPDATE incidentes SET ";
                    $params = array();

                    if ($classIncidente != null) {
                        $sql .= "classificacao = :classIncidente, ";
                        $params[':classIncidente'] = $classIncidente;
                    }

                    if ($protocoloERP != null) {
                        $sql .= "protocolo_erp = :protocoloERP, ";
                        $params[':protocoloERP'] = $protocoloERP;
                    }

                    if ($descEvento != null) {
                        $sql .= "descricaoEvento = :descricaoEvento, ";
                        $params[':descricaoEvento'] = $descEvento;
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
                    $params[':id'] = $incidente_id;

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);
                }

                $sql2 = "INSERT INTO incidentes_relatos (incidente_id, relato_autor, relato, horarioRelato, classificacao, previsaoNormalizacao) VALUES (:valor1, :valor4, :valor2, :valor3, :classificacao, :previsaoNormalizacao)";
                $stmt2 = $pdo->prepare($sql2);

                $stmt2->bindValue(':valor1', $incidente_id);
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
                    $sql_capture_zabbix_event_id = "SELECT i.zabbix_event_id FROM incidentes as i WHERE i.id = :incidente_id";
                    $stmt_capture_zabbix_event_id = $pdo->prepare($sql_capture_zabbix_event_id);
                    $stmt_capture_zabbix_event_id->bindValue(':incidente_id', $incidente_id);
                    $stmt_capture_zabbix_event_id->execute();

                    $zabbix_event_id_row = $stmt_capture_zabbix_event_id->fetch(PDO::FETCH_ASSOC);
                    $captura_zabbix_event_id = $zabbix_event_id_row['zabbix_event_id'];

                    if ($captura_zabbix_event_id && $c_integracao_zabbix['statusIntegracao'] == 1) {
                        $api_url = $c_integracao_zabbix['urlZabbix'];
                        $tokenZabbix = $c_integracao_zabbix['tokenAPI'];

                        $api_data = array(
                            "jsonrpc" => "2.0",
                            "method" => "event.acknowledge",
                            "params" => array(
                                "eventids" => "$captura_zabbix_event_id",
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
                    }
                }
            }
            //Fim do foreach
            header("Location: /servicedesk/incidentes/atualizacao_massa/index.php");
            exit();
        } else {
            //Se não tiver incidentes selecionados
            header("Location: /servicedesk/incidentes/atualizacao_massa/index.php");
            exit();
        }
    } else {
        //Se metodo de requisição não for POST
        header("Location: /servicedesk/incidentes/atualizacao_massa/index.php");
        exit();
    }
} else {
    //Se ussuario não tiver logado
    header("Location: /index.php");
    exit();
}
