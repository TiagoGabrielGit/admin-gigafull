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

    $dataConclusao = isset($_POST['dataConclusao']) ? $_POST['dataConclusao'] : null;
    $atendente = isset($_POST['selectAtendente']) ? $_POST['selectAtendente'] : 0;

    if ($row_itens['qtde'] > 0) {
        if (empty($_POST['assuntoChamado']) || empty($_POST['tipoChamado']) || empty($_POST['solicitante']) || empty($_POST['solicitante']) || empty($_POST['empresaChamado']) || empty($_POST['relatoChamado']) || empty($_POST['selectService']) || empty($_POST['selectIten'])) {
            echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos.</p>";
        } else {

            $assuntoChamado = $_POST['assuntoChamado'];
            $solicitante_id = $_POST['solicitante'];
            $relator_id = $_POST['solicitante'];
            $empresa_id = $_POST['empresaChamado'];
            $relato = $_POST['relatoChamado'];
            $service_id = $_POST['selectService'];
            $iten_id = $_POST['selectIten'];
            $tipochamado_id = $_POST['tipoChamado'];


            $cont_insert = false;

            $sql = "INSERT INTO chamados (atendente_id, data_prevista_conclusao, assuntoChamado, relato_inicial, tipochamado_id, solicitante_id, empresa_id, status_id, data_abertura, in_execution, in_execution_atd_id, seconds_worked, service_id, iten_service_id)
        VALUES (:atendente_id, :dataConclusao, :assuntoChamado, :relato_inicial, :tipochamado_id, :solicitante_id, :empresa_id, '1', NOW(), '0', '0', '0', :service_id, :iten_service_id)";
            $stmt1 = $pdo->prepare($sql);

            $stmt1 = $pdo->prepare($sql);
            $stmt1->bindParam(':assuntoChamado', $assuntoChamado);
            $stmt1->bindParam(':relato_inicial', $relato);
            $stmt1->bindParam(':tipochamado_id', $tipochamado_id);
            $stmt1->bindParam(':solicitante_id', $solicitante_id);
            $stmt1->bindParam(':empresa_id', $empresa_id);
            $stmt1->bindParam(':service_id', $service_id);
            $stmt1->bindParam(':iten_service_id', $iten_id);
            $stmt1->bindParam(':atendente_id', $atendente);
            if (empty($dataConclusao)) {
                $stmt1->bindParam(':dataConclusao', $dataConclusao, PDO::PARAM_NULL);
            } else {
                $stmt1->bindParam(':dataConclusao', $dataConclusao);
            }

            if ($stmt1->execute()) {
                $id_chamado = $pdo->lastInsertId();
                $cont_insert = true;

                // Verifica se o formulário foi enviado via POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['competencia_ids'])) {
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
                                }
                            }
                        }
                    }
                }
            } else {
                $cont_insert = false;
            }

            if ($cont_insert) {
                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                    $protocol = 'https';
                } else {
                    $protocol = 'http';
                }
                $documentRoot = $_SERVER['DOCUMENT_ROOT'];
                $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/notificacao/mail/abertura_chamado.php';

                $data = array(
                    'id_chamado' => $id_chamado
                );

                // Inicializa o cURL
                $curl = curl_init($url);

                // Configura as opções do cURL
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                // Executa a requisição cURL
                $response = curl_exec($curl);

                // Verifica se ocorreu algum erro durante a requisição
                if ($response === false) {
                    header("Location: /servicedesk/consultar_chamados/view.php?id=$id_chamado");
                    exit; // Encerra a execução do script após o redirecionamento
                } else {
                    header("Location: /servicedesk/consultar_chamados/view.php?id=$id_chamado");
                    exit; // Encerra a execução do script após o redirecionamento
                }
            } else {
                echo "<p style='color:red;'>Error: Erro ao abrir chamado.</p>";
            }
        }
    } else {
        if (empty($_POST['assuntoChamado']) || empty($_POST['tipoChamado']) || empty($_POST['solicitante']) || empty($_POST['solicitante']) || empty($_POST['empresaChamado']) || empty($_POST['relatoChamado']) || empty($_POST['selectService'])) {
            echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos.</p>";
        } else {
            $assuntoChamado = $_POST['assuntoChamado'];
            $solicitante_id = $_POST['solicitante'];
            $relator_id = $_POST['solicitante'];
            $empresa_id = $_POST['empresaChamado'];
            $relato = $_POST['relatoChamado'];
            $service_id = $_POST['selectService'];
            $tipochamado_id = $_POST['tipoChamado'];
            $cont_insert = false;

            $sql = "INSERT INTO chamados (atendente_id, data_prevista_conclusao, assuntoChamado, relato_inicial, tipochamado_id, solicitante_id, empresa_id, status_id, data_abertura, in_execution, in_execution_atd_id, seconds_worked, service_id)
            VALUES (:atendente_id, :dataConclusao, :assuntoChamado, :relato_inicial, :tipochamado_id, :solicitante_id, :empresa_id, '1', NOW(), '0', '0', '0', :service_id)";
            $stmt1 = $pdo->prepare($sql);
            $stmt1->bindParam(':assuntoChamado', $assuntoChamado);
            $stmt1->bindParam(':relato_inicial', $relato);
            $stmt1->bindParam(':tipochamado_id', $tipochamado_id);
            $stmt1->bindParam(':solicitante_id', $solicitante_id);
            $stmt1->bindParam(':empresa_id', $empresa_id);
            $stmt1->bindParam(':service_id', $service_id);
            $stmt1->bindParam(':atendente_id', $atendente);
            if (empty($dataConclusao)) {
                $stmt1->bindParam(':dataConclusao', $dataConclusao, PDO::PARAM_NULL);
            } else {
                $stmt1->bindParam(':dataConclusao', $dataConclusao);
            }



            if ($stmt1->execute()) {
                $id_chamado = $pdo->lastInsertId();
                $cont_insert = true;

                // Verifica se o formulário foi enviado via POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['competencia_ids'])) {
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
                                }
                            }
                        }
                    }
                }
            } else {
                $cont_insert = false;
            }

            if ($cont_insert) {

                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                    $protocol = 'https';
                } else {
                    $protocol = 'http';
                }
                $documentRoot = $_SERVER['DOCUMENT_ROOT'];
                $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/notificacao/mail/abertura_chamado.php';

                $data = array(
                    'id_chamado' => $id_chamado
                );

                // Inicializa o cURL
                $curl = curl_init($url);

                // Configura as opções do cURL
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                // Executa a requisição cURL
                $response = curl_exec($curl);

                // Verifica se ocorreu algum erro durante a requisição
                if ($response === false) {
                    header("Location: /servicedesk/consultar_chamados/view.php?id=$id_chamado");
                    exit; // Encerra a execução do script após o redirecionamento
                } else {
                    header("Location: /servicedesk/consultar_chamados/view.php?id=$id_chamado");
                    exit; // Encerra a execução do script após o redirecionamento
                }
            } else {
                echo "<p style='color:red;'>Error: Erro ao abrir chamado.</p>";
            }
        }
    }
}
