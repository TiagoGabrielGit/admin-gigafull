 <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (empty($_GET['assunto']) || empty($_GET['tipo']) || empty($_GET['solicitante']) || empty($_GET['empresa']) || empty($_GET['relato']) || empty($_GET['service'])) {
            echo "Dados obrigatórios não recebidos";
        } else {
            require "../conexoes/conexao_pdo.php";
            $assunto = $_GET['assunto'];
            $tipo = $_GET['tipo'];
            $solicitante = $_GET['solicitante'];
            $empresa = $_GET['empresa'];
            $relato = $_GET['relato'];
            $service = $_GET['service'];

            $cont_insert = false;

            $sql = "INSERT INTO chamados (assuntoChamado, relato_inicial, tipochamado_id, solicitante_id, empresa_id, status_id, data_abertura, seconds_worked, in_execution, atendente_id, service_id)
                    VALUES (:assuntoChamado, :relato_inicial, :tipochamado_id, :solicitante_id, :empresa_id, '1', NOW(), '0', '0', '0', :service)";

            $stmt1 = $pdo->prepare($sql);

            $stmt1->bindParam(':assuntoChamado', $assunto);
            $stmt1->bindParam(':relato_inicial', $relato);
            $stmt1->bindParam(':tipochamado_id', $tipo);
            $stmt1->bindParam(':solicitante_id', $solicitante);
            $stmt1->bindParam(':empresa_id', $empresa);
            $stmt1->bindParam(':service', $service);
            if ($stmt1->execute()) {
                $id_chamado = $pdo->lastInsertId();

                // Verificar se a solicitação foi feita via HTTPS
                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                    $protocol = 'https';
                } else {
                    $protocol = 'http';
                }

                // Formar a URL completa com base no Document Root
                $documentRoot = $_SERVER['DOCUMENT_ROOT'];
                $relativePath = '/notificacao/mail/abertura_chamado.php';

                $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $relativePath;
                $data = array('id_chamado' => $id_chamado);

                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data)
                    )
                );

                $context  = stream_context_create($options);
                $result = file_get_contents($url, false, $context);

                //echo "<script>var idChamado = " . $id_chamado . ";</script>";
                //echo "<script src='abertura_chamado.js'></script>";
            } else {
                echo "Falha ao abrir chamado";
            }
        }
    } else {
        echo "Método não reconhecido";
    }
