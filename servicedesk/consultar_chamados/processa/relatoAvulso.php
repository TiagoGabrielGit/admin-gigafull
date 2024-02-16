<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    $relatoRelator = $_POST['relatoRelator'];
    $relatoAvulsoChamado = $_POST['relatoAvulsoChamado'];
    $relatoAvulso = $_POST['relatoAvulso'];

    #Prepara a a insercao do relato no chamado
    $sql1 = "INSERT INTO chamado_relato (chamado_id, relator_id, relato, relato_hora_inicial, relato_hora_final, seconds_worked, private)
            VALUES (:chamado_id, :relator_id, :relato, NOW(), NOW(), '0', '1')";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindParam(':relator_id', $relatoRelator);
    $stmt1->bindParam(':chamado_id', $relatoAvulsoChamado);
    $stmt1->bindParam(':relato', $relatoAvulso);

    if ($stmt1->execute()) {

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        $host = $_SERVER['HTTP_HOST'];
        $id_chamado = $relatoAvulsoChamado;

        // Configuração da requisição cURL para /notificacao/mail/relato_chamado.php
        $url_mail = $protocol . '://' . $host . '/notificacao/mail/relato_chamado.php';
        $data_mail = array(
            'id_chamado' => $id_chamado
        );
        $curl_mail = curl_init($url_mail);
        curl_setopt($curl_mail, CURLOPT_POST, true);
        curl_setopt($curl_mail, CURLOPT_POSTFIELDS, $data_mail);
        curl_setopt($curl_mail, CURLOPT_RETURNTRANSFER, true);
        $response_mail = curl_exec($curl_mail);


        // Configuração da requisição cURL para /notificacao/telegram/relato_chamado.php
        $url_telegram = $protocol . '://' . $host . '/notificacao/telegram/relato_chamado.php';
        $data_telegram = array(
            'id_chamado' => $id_chamado
        );
        $curl_telegram = curl_init($url_telegram);
        curl_setopt($curl_telegram, CURLOPT_POST, true);
        curl_setopt($curl_telegram, CURLOPT_POSTFIELDS, $data_telegram);
        curl_setopt($curl_telegram, CURLOPT_RETURNTRANSFER, true);
        $response_telegram = curl_exec($curl_telegram);


        // Verificação de erros durante as requisições
        if ($response_mail === false || $response_telegram === false) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
