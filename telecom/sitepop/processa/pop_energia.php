<?php
session_start();

if ($_SESSION['id']) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";
        if (!empty($_POST['tempoAutonomia'])) {
            $tempoAutonomia = $_POST['tempoAutonomia'];

            try {
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Verificar se já existe um registro com o pop_id fornecido
                $pop_id = $_POST['autonomia_id_pop'];
                $sql = "SELECT * FROM pop_energia WHERE pop_id = :pop_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':pop_id', $pop_id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    // Se o registro existe, faz um UPDATE
                    $sql = "UPDATE pop_energia SET energia_autonomia = :energia_autonomia WHERE pop_id = :pop_id";
                } else {
                    // Caso contrário, faz um INSERT
                    $sql = "INSERT INTO pop_energia (pop_id, energia_autonomia) VALUES (:pop_id, :energia_autonomia)";
                }

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':pop_id', $pop_id);
                $stmt->bindParam(':energia_autonomia', $tempoAutonomia);
                $stmt->execute();

                // Verificação se o UPDATE ou INSERT foi bem-sucedido
                if ($stmt->rowCount() > 0) {
                    header("Location: /telecom/sitepop/view.php?id=$pop_id&tab=energia");
                    exit;
                } else {
                    header("Location: /telecom/sitepop/view.php?id=$pop_id&tab=energia");
                    exit;
                }
            } catch (PDOException $e) {
                header("Location: /telecom/sitepop/view.php?id=$pop_id&tab=energia");
                exit;
            }
        }
    }
}
