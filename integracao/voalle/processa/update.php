<?php
session_start();
if ($_SESSION['id']) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";

        $urlVoalle = $_POST['urlVoalle'];
        $syndata = $_POST['syndata'];
        $usuarioIntegracao = $_POST['usuarioIntegracao'];
        $senhaIntegracao = $_POST['senhaIntegracao'];
        $statusIntegracao = $_POST['statusIntegracao'];
        $tokenAPI = $_POST['tokenAPI'];
        $api_request_token = $_POST['api_request_token'];
        $api_relatos_solicitacao = $_POST['api_relatos_solicitacao'];
        $api_detalhes_solicitacao = $_POST['api_detalhes_solicitacao'];
        $tokenEstatico = $_POST['tokenEstatico'];
        $hostDB = $_POST['hostDB'];
        $usuarioDB = $_POST['usuarioDB'];
        $senhaDB = $_POST['senhaDB'];


        $sql = "UPDATE integracao_voalle SET urlVoalle = :urlVoalle, active = :statusIntegracao, 
        token = :tokenAPI, usuario_integracao = :usuario_integracao, senha_integracao = :senha_integracao,
         syndata = :syndata, api_relatos_solicitacao = :api_relatos_solicitacao, api_request_token = :api_request_token,
          token_estatico = :token_estatico, api_detalhes_solicitacao = :api_detalhes_solicitacao, host_db = :hostDB, user_db = :usuarioDB, pass_db = :senhaDB";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':urlVoalle', $urlVoalle);
        $stmt->bindParam(':syndata', $syndata);
        $stmt->bindParam(':usuario_integracao', $usuarioIntegracao);
        $stmt->bindParam(':senha_integracao', $senhaIntegracao);
        $stmt->bindParam(':statusIntegracao', $statusIntegracao);
        $stmt->bindParam(':tokenAPI', $tokenAPI);
        $stmt->bindParam(':token_estatico', $tokenEstatico);
        $stmt->bindParam(':api_detalhes_solicitacao', $api_detalhes_solicitacao);
        $stmt->bindParam(':api_request_token', $api_request_token);
        $stmt->bindParam(':api_relatos_solicitacao', $api_relatos_solicitacao);
        $stmt->bindParam(':hostDB', $hostDB);
        $stmt->bindParam(':usuarioDB', $usuarioDB);
        $stmt->bindParam(':senhaDB', $senhaDB);

        $stmt->execute();

        header("Location: /integracao/voalle/index.php"); // Substitua "index.php" pelo caminho apropriado
    } else {
        echo "Método incorreto!";
    }
} else {
    echo "Usuário não logado";
}
