<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require "../../../conexoes/conexao_pdo.php"; // Certifique-se de incluir a configuração da conexão PDO

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Recupera os valores enviados via POST
            $oltInteressado = $_POST['oltInteressado'];
            $empresaInteressada = $_POST['empresaInteressada'];
            $active = "1";


            // Insere os dados na tabela gpon_olts_interessados
            $sql = "INSERT INTO gpon_olts_interessados (gpon_olt_id, interessado_empresa_id, active) VALUES (:oltInteressado, :empresaInteressada, :active)";

            // Prepara e executa a declaração preparada
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':oltInteressado', $oltInteressado, PDO::PARAM_INT);
            $stmt->bindParam(':empresaInteressada', $empresaInteressada, PDO::PARAM_INT);
            $stmt->bindParam(':active', $active, PDO::PARAM_INT);

            $stmt->execute();

            header("Location: /rede/gpon/interessados.php?olt_id=$oltInteressado");
            exit();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            //header("Location: /rede/erro_generico.php");
            //exit();
        }
    } else {
        // Se o método de requisição não for POST, redirecione para outra página ou exiba uma mensagem de erro
        echo "Método de requisição inválido";
        // Ou redirecione para outra página usando header() ou exiba uma mensagem de erro
    }
} else {
    header("Location: /index.php");
    exit();
}
