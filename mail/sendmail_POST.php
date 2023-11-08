<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../conexoes/conexao_pdo.php";

    if (empty($_POST['destinatario']) || empty($_POST['assunto']) || empty($_POST['mensagem']) || empty($_POST['servidorID'])) {
        echo "Error: Dados obrigatórios não preenchidos.";
    } else {

        $destinatario = $_POST['destinatario'];
        $assunto = $_POST['assunto'];
        $mensagem = nl2br($_POST['mensagem']);
        $servidorSTMP = $_POST['servidorID'];

        require 'mailer/src/Exception.php';
        require 'mailer/src/PHPMailer.php';
        require 'mailer/src/SMTP.php';

        // Prepara a consulta SQL
        $sql = "SELECT * FROM servermail WHERE id = :serverId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':serverId', $servidorSTMP);

        // Executa a consulta
        $stmt->execute();

        // Verifica se encontrou o servidor
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $host = $row['host'];
            $user = $row['user'];
            $pass = $row['password'];
            $autenticacao = $row['authentication'];
            $port = $row['port'];
            $remetente = $row['remetente'];
            $active = $row['active'];

            if ($active == "1") {

                // Instanciar objeto PHPMailer
                $mail = new PHPMailer(true);
                $mail->Encoding = 'base64';

                try {
                    $mail->CharSet = 'UTF-8';
                    $mail->isHTML(true); // Indicar que o conteúdo é HTML
                    // Configurações do servidor SMTP
                    $mail->isSMTP();
                    $mail->Host = $host;
                    $mail->SMTPAuth = true;
                    $mail->Username = $user;
                    $mail->Password = $pass;
                    $mail->SMTPSecure = $autenticacao;
                    $mail->Port = $port;

                    // Remetente e destinatários
                    $mail->setFrom($remetente);

                    $destinatarios = explode(',', $destinatario);

                    foreach ($destinatarios as $destinatario) {
                        $mail->addBCC(trim($destinatario));
                    }

                    // Conteúdo do email
                    $mail->Subject = $assunto;
                    $mail->Body = $mensagem;

                    // Enviar o email
                    $mail->send();


                    echo "E-mail enviado com sucesso!";
                    echo $destinatario;
                    echo $assunto;
                    echo $mensagem;
                    echo $servidorSTMP;

                    echo "Success: E-mail enviado com sucesso.<br><br>" . $_POST['mensagem'];
                } catch (Exception $e) {
                    echo "Error: Erro ao enviar o email:" . $mail->ErrorInfo;
                    
                }
            } else {
                echo "Error: Servidor de e-mail inativado.";
            }
        }
    }
}
