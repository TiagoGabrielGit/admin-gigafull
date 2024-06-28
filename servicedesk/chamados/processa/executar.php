<?php
session_start();
if (isset($_SESSION['id'])) {
    require "../../../conexoes/conexao.php";
    require "../../../conexoes/conexao_pdo.php";

    $chamado_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $consulta_chamado = "SELECT atendente_id FROM chamados WHERE id = :chamado_id";
    $stmt = $pdo->prepare($consulta_chamado);
    $stmt->bindParam(':chamado_id', $chamado_id, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SESSION['id'] == $resultado['atendente_id']) {

        $pessoa_id = filter_input(INPUT_GET, 'pessoa', FILTER_SANITIZE_NUMBER_INT);

        $sql = "UPDATE `chamados` SET `in_execution`= '1', `in_execution_atd_id`= '$pessoa_id', `in_execution_start`= NOW() WHERE id = '$chamado_id' ";
        $res = mysqli_query($mysqli, $sql);


        if (mysqli_affected_rows($mysqli)) {
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $protocol = 'https';
            } else {
                $protocol = 'http';
            }
            $documentRoot = $_SERVER['DOCUMENT_ROOT'];
            $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/notificacao/mail/execucao_chamado.php';

            $data = array(
                'id_chamado' => $chamado_id
            );

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // Executa a requisição cURL
            $response = curl_exec($curl);

            // Verifica se ocorreu algum erro durante a requisição
            if ($response === false) {
                header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");
                exit; // Encerra a execução do script após o redirecionamento
            } else {
                header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");
                exit; // Encerra a execução do script após o redirecionamento
            }
        } else {
            header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");
            exit();
        }
    } else {
        $_SESSION['msg_error'] = "Este chamado esta apropriado por outro atendente";
        header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
