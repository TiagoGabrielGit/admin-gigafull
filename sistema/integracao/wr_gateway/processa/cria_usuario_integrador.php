<?php
session_start();
if (isset($_SESSION['id'])) {

    function gerarSenhaAleatoria($tamanho)
    {
        $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $senha = "";
        for ($i = 0; $i < $tamanho; $i++) {
            $senha .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        return $senha;
    }

    require "../../../../conexoes/conexao_pdo.php";
    try {

        $novaSenha = gerarSenhaAleatoria(8);
        $novaSenhaMD5 = md5($novaSenha);
        $nomeUsuario = $_POST['nomeUsuario'];
        $emailUsuario = $_POST['emailUsuario'];
        $id = "1";

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE integracao_wr_gateway SET usuario_integrador = :nome, senha_integrador = :senha, email_integrador = :email WHERE id = :id ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nomeUsuario);
        $stmt->bindParam(':senha', $novaSenhaMD5);
        $stmt->bindParam(':email', $emailUsuario);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        // Passo 5: Enviar uma solicitação POST para a API externa
        $apiUrl = $_POST['WRurl'] . "/signup"; // Substitua com a URL da API externa
        $apiData = array(
            'name' => $nomeUsuario,
            'email' => $emailUsuario,
            'password' => $novaSenha
        );

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $apiResponse = curl_exec($ch);

        if ($apiResponse === FALSE) {
            $_SESSION['apiResponse'] =  curl_error($ch);
            header("Location: /sistema/integracao/wr_gateway/index.php");
            exit();
        } else {
            $_SESSION['apiResponse'] =  $apiResponse;
            header("Location: /sistema/integracao/wr_gateway/index.php");
            exit();
        }

        curl_close($ch);
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    }
}
