<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require "../../conexoes/conexao_pdo.php";

        // Consulta se o envio de e-mail está habilitado
        $consulta_habilitado = "
        SELECT
            ne.active as active,
            ne.server_id as server_id
        FROM
            notificacao_email as ne
        WHERE
            ne.notificacao_id = 7
    ";

        // Executa a consulta no banco de dados
        $result_habilitado = $pdo->query($consulta_habilitado);
        $c_habilitado = $result_habilitado->fetch(PDO::FETCH_ASSOC);
        $active = $c_habilitado['active'];
        $server_id = $c_habilitado['server_id'];

        // Se habilitado, coleta informações do chamado.
        if ($active == 1) {
            $id_mp = $_POST['aprovacao_id_mp'];

            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $infosMP = "SELECT mp.titulo as titulo, mp.descricao as descricao, mp.dataAgendamento as dataAgendamento, mp.duracao as duracao FROM manutencao_programada as mp WHERE mp.id = :id";
                $stmtMP = $pdo->prepare($infosMP);
                $stmtMP->bindParam(':id', $id_mp, PDO::PARAM_INT);
                $stmtMP->execute();
                $resultMP = $stmtMP->fetch(PDO::FETCH_ASSOC);
                $mpTitulo = $resultMP['titulo'];
                $descricao = $resultMP['descricao'];
                $dataAgendamento = $resultMP['dataAgendamento'];
                $duracao = $resultMP['duracao'];


                $querySelectEmails = "SELECT mpra.email as email, mpra.id as id
                FROM manutencao_programada_responsaveis_aceite as mpra
                WHERE mpra.active = 1";

                $stmtSelectEmails = $pdo->prepare($querySelectEmails);
                $stmtSelectEmails->execute();
                $results = $stmtSelectEmails->fetchAll(PDO::FETCH_ASSOC);

                if (count($results) > 0) {
                    $cont = 1;
                    foreach ($results as $row) {
                        $id_contato = $row['id'];
                        $email = $row['email'];
                        $token = bin2hex(random_bytes(16));

                        $queryInsertEmail = "INSERT INTO manutencao_programada_aprovacao (id_manutencao, token, contato_id, status, date_send) 
                                        VALUES (:id_manutencao, :token, :contato_id, 1, NOW())";

                        $stmtInsertEmail = $pdo->prepare($queryInsertEmail);
                        $stmtInsertEmail->bindParam(':id_manutencao', $id_mp);
                        $stmtInsertEmail->bindParam(':token', $token);
                        $stmtInsertEmail->bindParam(':contato_id', $id_contato);
                        $stmtInsertEmail->execute();

                        $relativePath = '/servicedesk/manutencao_programada/manutencoes_programadas/request_approval.php';

                        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                            $protocol = 'https';
                        } else {
                            $protocol = 'http';
                        }

                        $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $relativePath . '?token=' . $token;


                        $assunto = "VOA | Aprovação de Manutenção Programada";
                        $mensagem = "Olá!<br>";
                        $mensagem .= "Requisitamos sua autorização para realizar a seguinte manutenção programada:<br><br>";
                        $mensagem .=  "<b>Manutenção ID:</b> $id_mp<br>";
                        $mensagem .= "<b>Titulo:</b> $mpTitulo<br>";
                        $mensagem .= "<b>Descrição:</b> $descricao<br>";
                        $mensagem .= "<b>Data Agendamento:</b> $dataAgendamento<br>";
                        $mensagem .= "<b>Duração:</b> $duracao Hora/s<br>";

                        $mensagem .= "<br><b>Para mais informações e responder esta solicitação, responda através do link abaixo:</b><br> $url <br><br>";

                        $mensagem .= "<b>Caso a solicitação não for respondida em até 3 dias a partir deste recebimento a mesma sera considerada aprovada.</b><br><br>";

                        $servidorSMTP = "1";

                        $postData = array(
                            'destinatario' => $email,
                            'assunto' => $assunto,
                            'mensagem' => $mensagem,
                            'servidorID' => $servidorSMTP,
                        );
                        // Formar a URL completa com base no Document Root
                        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
                        $relativePath = '/mail/sendmail_POST.php';

                        // Verificar se a solicitação foi feita via HTTPS
                        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                            $protocol = 'https';
                        } else {
                            $protocol = 'http';
                        }

                        $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $relativePath;
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                        $result = curl_exec($ch);

                        // Verificar erros
                        if ($result === false) {
                            echo 'Erro ao enviar a solicitação POST para sendmail_POST.php: ' . curl_error($ch);
                        }

                        curl_close($ch);
                    }
                } else {
                    echo "Nenhum e-mail encontrado na tabela de responsáveis.";
                }
            } catch (PDOException $e) {
                echo "Erro de conexão com o banco de dados: " . $e->getMessage();
            }
        } else {
?>
            <main id="main" class="main">

                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh;">
                                                <h5 style="text-align: center;" class="card-title">Envio de aprovação não habilitado</h5>
                                                <a style="text-align: center" href="javascript:history.go(-1)">Voltar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </main>
<?php
        }
    } else {
        echo "Método incorreto";
    }
} else {
    echo "Usuário não autenticado";
}
