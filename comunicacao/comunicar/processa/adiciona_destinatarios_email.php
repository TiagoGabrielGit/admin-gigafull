<?php
session_start();

if ($_SESSION['id']) {
    require "../../../conexoes/conexao_pdo.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["idComunicacao"])) {
            $idComunicacao = $_POST["idComunicacao"];

            $empresa_notificacao_id = $_POST["empresa_notificacao_id"];
            $active = "1";

            // Agora, insira os dados na tabela comunicacao_destinatarios
            $inserir_destinatario = "INSERT INTO comunicacao_destinatarios (comunicacao_id, empresa_notificacao_id, active) VALUES (:comunicacao_id, :empresa_notificacao_id, :active)";

            $stmt = $pdo->prepare($inserir_destinatario);
            $stmt->bindParam(':comunicacao_id', $idComunicacao, PDO::PARAM_INT);
            $stmt->bindParam(':empresa_notificacao_id', $empresa_notificacao_id, PDO::PARAM_INT);
            $stmt->bindParam(':active', $active, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: /comunicacao/comunicar/index.php");
                exit();
            } else {
                header("Location: /comunicacao/comunicar/index.php");
                exit();
            }
        } else {
            header("Location: /comunicacao/comunicar/index.php");
            exit();
        }
    } else {
        echo "Requisição inválida.";
    }
}
