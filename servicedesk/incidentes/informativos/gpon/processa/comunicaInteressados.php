<?php
session_start();
if (isset($_SESSION['id'])) {
    $uid = $_SESSION['id'];

    if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../../../conexoes/conexao_pdo.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idIncidente = $_POST['icdID'];
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $idIncidente = $_GET['incidenteID'];
        }



        $sql = "SELECT i.incident_type as it FROM incidentes as i WHERE i.id = :incidenteID";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':incidenteID', $idIncidente, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $c_incidente = $stmt->fetch(PDO::FETCH_ASSOC);
            $tipo = $c_incidente['it'];

            if ($tipo == 102) {
                $interessadosSql =
                    "SELECT en.id as id, en.midia as email
                    FROM incidentes as i
                    LEFT JOIN rotas_fibra as rf ON rf.codigo = i.equipamento_id
                    LEFT JOIN rotas_fibras_interessados as rfi ON rf.id = rfi.rf_id
                    LEFT JOIN empresas_notificacao as en ON en.empresa_id = rfi.interessado_empresa_id
                    WHERE i.id = :idIncidente AND rfi.active = 1 AND en.active = 1 AND en.metodo_id = 1";
            } else if ($tipo == 100) {
                $interessadosSql =
                    "SELECT en.id as id, en.midia as email
                    FROM incidentes as i
                    LEFT JOIN gpon_pon as gp ON gp.id = i.pon_id
                    LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = gp.olt_id
                    LEFT JOIN empresas_notificacao as en ON en.empresa_id = goi.interessado_empresa_id
                    WHERE i.id = :idIncidente AND goi.active = 1 AND en.active = 1 AND en.metodo_id = 1";
            }

            $stmtInteressados = $pdo->prepare($interessadosSql);
            $stmtInteressados->bindParam(':idIncidente', $idIncidente, PDO::PARAM_INT);

            if ($stmtInteressados->execute()) {
                $resultadosInteressados = $stmtInteressados->fetchAll(PDO::FETCH_ASSOC);

                // Inserir o registro na tabela comunicacao
                $cria_comunicacao = "INSERT INTO comunicacao (usuario_criador, created, incidente_id, status, step, origem, origem_id) VALUES (:usuario_criador, NOW(), :incidente_id, 1, 1, 1, :origem_id)";
                $stmtInsertComunicacao = $pdo->prepare($cria_comunicacao);
                $stmtInsertComunicacao->bindParam(':usuario_criador', $uid, PDO::PARAM_INT);
                $stmtInsertComunicacao->bindParam(':incidente_id', $idIncidente, PDO::PARAM_INT);
                $stmtInsertComunicacao->bindParam(':origem_id', $idIncidente, PDO::PARAM_INT);

                if ($stmtInsertComunicacao->execute()) {
                    $idComunicacao = $pdo->lastInsertId();

                    foreach ($resultadosInteressados as $resultado) {
                        $email = $resultado['email'];
                        $idEmpNot = $resultado['id'];

                        $insertDest = "INSERT INTO comunicacao_destinatarios (comunicacao_id, empresa_notificacao_id, active) VALUES (:comunicacao_id, :empresa_notificacao_id, 1)";
                        $stmtInsertDest = $pdo->prepare($insertDest);
                        $stmtInsertDest->bindParam(':comunicacao_id', $idComunicacao, PDO::PARAM_INT);
                        $stmtInsertDest->bindParam(':empresa_notificacao_id', $idEmpNot, PDO::PARAM_STR);
                        $stmtInsertDest->execute();
                    }

                    header("Location: /comunicacao/comunicar/index.php");
                    exit();
                } else {
                    echo "Erro ao executar a consulta de interessados.";
                }
            }
        }
    }
} else {
    echo "No session";
}
