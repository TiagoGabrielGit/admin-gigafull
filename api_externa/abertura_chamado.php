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
                $id_chamado = $pdo->lastInsertId(); ?>

             <script>
                 setTimeout(function() {
                     var chamadoId = <?= $id_chamado ?>;
                     fetch('/notificacao/mail/abertura_chamado.php', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/x-www-form-urlencoded',
                         },
                         body: 'id_chamado=' + chamadoId
                     }).then(function(response) {
                         if (response.ok) {
                            //Tratamento para ok
                         } else {
                             console.error('Erro na requisição. Status:', response.status);
                         }
                     }).catch(function(error) {
                         console.error('Erro na requisição:', error);
                     });
                 });
             </script>

 <?php } else {
                echo "Falha ao abrir chamado";
            }
        }
    } else {
        echo "Método não reconhecido";
    }