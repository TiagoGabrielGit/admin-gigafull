<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty('interessadosIdChamado') || empty('interessadosEmail')) {
        $idChamado = $_POST['interessadosIdChamado'];

        header("Location: ../view.php?id=$idChamado.php");
        exit();
    } else {
        $idChamado = $_POST['interessadosIdChamado'];
        $interessadosEmail = $_POST['interessadosEmail'];
        require "../../../conexoes/conexao_pdo.php";
        $sql = "INSERT INTO chamados_interessados (chamado_id, email, active) VALUES (:idChamado, :email, '1')";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':idChamado', $idChamado);
        $stmt->bindParam(':email', $interessadosEmail);

        if ($stmt->execute()) {

            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $protocol = 'https';
            } else {
                $protocol = 'http';
            }
            $documentRoot = $_SERVER['DOCUMENT_ROOT'];
            $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/notificacao/mail/add_interessado.php';

            $data = array(
                'idChamado' => $idChamado,
                'email' => $interessadosEmail
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
}
