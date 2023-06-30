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
        $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/notificacao/mail/relato_chamado.php';

        $data = array(
            'id_chamado' => $relatoAvulsoChamado
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
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit; // Encerra a execução do script após o redirecionamento
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit; // Encerra a execução do script após o redirecionamento
        }
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
