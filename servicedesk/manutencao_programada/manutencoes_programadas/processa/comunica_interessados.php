<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../../conexoes/conexao_pdo.php";

        $uid = $_SESSION['id'];
        $idMP = $_POST['idMPG'];

        $cria_comunicacao = "INSERT INTO comunicacao (usuario_criador, created, status, step, origem, origem_id) VALUES (:usuario_criador, NOW(), 1, 1, 2, :origem_id)";
        $stmtInsertComunicacao = $pdo->prepare($cria_comunicacao);
        $stmtInsertComunicacao->bindParam(':usuario_criador', $uid, PDO::PARAM_INT);
        $stmtInsertComunicacao->bindParam(':origem_id', $idMP, PDO::PARAM_INT);

        if ($stmtInsertComunicacao->execute()) {
            $idComunicacao = $pdo->lastInsertId();

            $consulta =
                "SELECT en.id as id, en.midia as email
            FROM manutencao_gpon as mg
            LEFT JOIN gpon_pon as gp ON gp.id = mg.pon_id
            LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = gp.olt_id
            LEFT JOIN empresas_notificacao as en ON en.empresa_id = goi.interessado_empresa_id
            WHERE mg.manutencao_id = :idMP and goi.active = 1 AND en.active AND en.metodo_id = 1
            GROUP BY en.midia
        
            UNION
        
            SELECT en.id as id, en.midia as email
            FROM manutencao_rotas_fibra as mrf
            LEFT JOIN rotas_fibra as rf ON rf.id = mrf.rota_id
            LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = rf.id
            LEFT JOIN empresas_notificacao as en ON en.empresa_id = rfi.interessado_empresa_id
            WHERE mrf.manutencao_id = :idMP AND rfi.active = 1 AND en.active = 1 AND en.metodo_id = 1
            GROUP BY en.midia
        ";

            $stmtConsulta = $pdo->prepare($consulta);
            $stmtConsulta->bindParam(':idMP', $idMP, PDO::PARAM_INT);

            if ($stmtConsulta->execute()) {
                $r_Consulta = $stmtConsulta->fetchAll(PDO::FETCH_ASSOC);

                foreach ($r_Consulta as $resultado) {
                    $email = $resultado['email'];
                    $idEmpNot = $resultado['id'];

                    $insertDest = "INSERT INTO comunicacao_destinatarios (comunicacao_id, empresa_notificacao_id, active) VALUES (:comunicacao_id, :empresa_notificacao_id, 1)";
                    $stmtInsertDest = $pdo->prepare($insertDest);
                    $stmtInsertDest->bindParam(':comunicacao_id', $idComunicacao, PDO::PARAM_INT);
                    $stmtInsertDest->bindParam(':empresa_notificacao_id', $idEmpNot, PDO::PARAM_STR);
                    $stmtInsertDest->execute();
                }
            }

            header("Location: /comunicacao/comunicar/index.php");
            exit();
        }
    }
}
