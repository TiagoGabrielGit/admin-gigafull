<?php
session_start();

if ($_SESSION['id']) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../../conexoes/conexao_pdo.php";

        // Dados do formulário
        // Dados do formulário
        $id = "1";
        $urlWR = isset($_POST["url"]) ? $_POST["url"] : "";
        $dateBefor = isset($_POST["dateBefor"]) ? $_POST["dateBefor"] : "";
        $statusIntegracao = $_POST["statusIntegracao"];
        $token = isset($_POST["token"]) ? $_POST["token"] : "";
        $mensagem = isset($_POST["mensagem"]) ? $_POST["mensagem"] : "";
        $locIC = isset($_POST["locIC"]) ? $_POST["locIC"] : "";
        
        try {
            $sql = "UPDATE integracao_wr_gateway SET urlWR = :urlWR, token = :token, dateBefor = :dateBefor, mensagem_default = :mensagem, active = :statusIntegracao, location_incident_scheduler = :location_incident_scheduler WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":id", $id);

            $stmt->bindParam(":urlWR", $urlWR);
            $stmt->bindParam(":dateBefor", $dateBefor);
            $stmt->bindParam(":statusIntegracao", $statusIntegracao);
            $stmt->bindParam(":token", $token);
            $stmt->bindParam(":mensagem", $mensagem);
            $stmt->bindParam(":location_incident_scheduler", $locIC);

            $stmt->execute();

            header("Location: /sistema/integracao/wr_gateway/index.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header("Location: /sistema/integracao/wr_gateway/index.php");
        exit();
    }
}
