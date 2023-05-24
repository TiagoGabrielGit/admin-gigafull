<?php
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

if (empty($_POST['selectService'])) {
    echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos.</p>";
} else {
    $idServico = $_POST['selectService'];
    $sql_qtde_itens =
        "SELECT
       count(cis.id) as qtde
        FROM
        contract_iten_service as cis
        LEFT JOIN
        contract_service as cs
        ON
        cis.contract_service_id = cs.id
        LEFT JOIN
        iten_service as ise
        ON
        ise.id = cis.iten_service
        WHERE
        cis.active = 1
        and
        cs.active = 1
        and
        cs.id = $idServico
        ORDER BY
        ise.item ASC";
    $r_itens = $mysqli->query($sql_qtde_itens);
    $row_itens = $r_itens->fetch_assoc();

    if ($row_itens['qtde'] > 0) {
        if (empty($_POST['assuntoChamado']) || empty($_POST['tipoChamado']) || empty($_POST['solicitante']) || empty($_POST['solicitante']) || empty($_POST['empresaChamado']) || empty($_POST['relatoChamado']) || empty($_POST['selectService']) || empty($_POST['selectIten'])) {
            echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos.</p>";
        } else {

            $assuntoChamado = $_POST['assuntoChamado'];
            $tipochamado_id = $_POST['tipoChamado'];
            $solicitante_id = $_POST['solicitante'];
            $relator_id = $_POST['solicitante'];
            $empresa_id = $_POST['empresaChamado'];
            $relato = $_POST['relatoChamado'];
            $service_id = $_POST['selectService'];
            $iten_id = $_POST['selectIten'];

            $cont_insert = false;

            $sql = "INSERT INTO chamados (atendente_id, assuntoChamado, relato_inicial, tipochamado_id, solicitante_id, empresa_id, status_id, data_abertura, in_execution, in_execution_atd_id, seconds_worked, service_id, iten_service_id)
        VALUES ('0', :assuntoChamado, :relato_inicial, :tipochamado_id, :solicitante_id, :empresa_id, '1', NOW(), '0', '0', '0', :service_id, :iten_service_id)";
            $stmt1 = $pdo->prepare($sql);

            $stmt1 = $pdo->prepare($sql);
            $stmt1->bindParam(':assuntoChamado', $assuntoChamado);
            $stmt1->bindParam(':relato_inicial', $relato);
            $stmt1->bindParam(':tipochamado_id', $tipochamado_id);
            $stmt1->bindParam(':solicitante_id', $solicitante_id);
            $stmt1->bindParam(':empresa_id', $empresa_id);
            $stmt1->bindParam(':service_id', $service_id);
            $stmt1->bindParam(':iten_service_id', $iten_id);

            if ($stmt1->execute()) {
                $id_chamado = $pdo->lastInsertId();


                // Verifica se o formulário foi enviado via POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Recupera os IDs das competências marcadas
                    $competenciaIds = $_POST['competencia_ids'];

                    // Percorre os IDs das competências marcadas
                    foreach ($competenciaIds as $competenciaId) {
                        // Verifica se o checkbox correspondente à competência está marcado
                        if (isset($_POST['competencia' . $competenciaId])) {
                            $insert_competencias = "INSERT INTO chamados_competencias (chamado_id, competencia_id) VALUES (:chamado_id, :competencia_id)";
                            $stmtCompetencia = $pdo->prepare($insert_competencias);
                            $stmtCompetencia->bindParam(':chamado_id', $id_chamado);
                            $stmtCompetencia->bindParam(':competencia_id', $competenciaId);

                            if ($stmtCompetencia->execute()) {
                                $cont_insert = true;
                            }
                        }
                    }
                }
            } else {
                $cont_insert = false;
            }

            if ($cont_insert) {
                echo "<p style='color:green;'>Code 006: Chamado aberto com sucesso. Chamado $id_chamado</p>";
            } else {
                echo "<p style='color:red;'>Error: Erro ao abrir chamado.</p>";
            }
        }
    } else {
        if (empty($_POST['assuntoChamado']) || empty($_POST['tipoChamado']) || empty($_POST['solicitante']) || empty($_POST['solicitante']) || empty($_POST['empresaChamado']) || empty($_POST['relatoChamado']) || empty($_POST['selectService'])) {
            echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos.</p>";
        } else {
            $assuntoChamado = $_POST['assuntoChamado'];
            $tipochamado_id = $_POST['tipoChamado'];
            $solicitante_id = $_POST['solicitante'];
            $relator_id = $_POST['solicitante'];
            $empresa_id = $_POST['empresaChamado'];
            $relato = $_POST['relatoChamado'];
            $service_id = $_POST['selectService'];

            $cont_insert = false;

            $sql = "INSERT INTO chamados (atendente_id, assuntoChamado, relato_inicial, tipochamado_id, solicitante_id, empresa_id, status_id, data_abertura, in_execution, in_execution_atd_id, seconds_worked, service_id)
        VALUES ('0', :assuntoChamado, :relato_inicial, :tipochamado_id, :solicitante_id, :empresa_id, '1', NOW(), '0', '0', '0', :service_id)";
            $stmt1 = $pdo->prepare($sql);
            $stmt1->bindParam(':assuntoChamado', $assuntoChamado);
            $stmt1->bindParam(':relato_inicial', $relato);
            $stmt1->bindParam(':tipochamado_id', $tipochamado_id);
            $stmt1->bindParam(':solicitante_id', $solicitante_id);
            $stmt1->bindParam(':empresa_id', $empresa_id);
            $stmt1->bindParam(':service_id', $service_id);

            if ($stmt1->execute()) {
                $id_chamado = $pdo->lastInsertId();


                // Verifica se o formulário foi enviado via POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Recupera os IDs das competências marcadas
                    $competenciaIds = $_POST['competencia_ids'];

                    // Percorre os IDs das competências marcadas
                    foreach ($competenciaIds as $competenciaId) {
                        // Verifica se o checkbox correspondente à competência está marcado
                        if (isset($_POST['competencia' . $competenciaId])) {
                            $insert_competencias = "INSERT INTO chamados_competencias (chamado_id, competencia_id) VALUES (:chamado_id, :competencia_id)";
                            $stmtCompetencia = $pdo->prepare($insert_competencias);
                            $stmtCompetencia->bindParam(':chamado_id', $id_chamado);
                            $stmtCompetencia->bindParam(':competencia_id', $competenciaId);

                            if ($stmtCompetencia->execute()) {
                                $cont_insert = true;
                            }
                        }
                    }
                }
            } else {
                $cont_insert = false;
            }

            if ($cont_insert) {
                echo "<p style='color:green;'>Code 004: Chamado aberto com sucesso. Chamado $id_chamado</p>";
            } else {
                echo "<p style='color:red;'>Error: Erro ao abrir chamado.</p>";
            }
        }
    }
}
