<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: /index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Método inválido."]);
    exit();
}

require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

try {
    $user_id = $_SESSION['id'];
    $note = $_POST['note'];

    // Preparar a consulta SQL para verificar se a nota já existe para este usuário
    $sql_check = "SELECT * FROM bloco_de_notas WHERE user_id = :user_id";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        // Se existir, atualizar a nota
        $sql_update = "UPDATE bloco_de_notas SET note = :note WHERE user_id = :user_id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':note', $note, PDO::PARAM_STR);
        $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        if ($stmt_update->execute()) {
            echo json_encode(["status" => "success", "message" => "Nota atualizada com sucesso."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao atualizar a nota."]);
        }
    } else {
        // Se não existir, inserir uma nova nota
        $sql_insert = "INSERT INTO bloco_de_notas (user_id, note) VALUES (:user_id, :note)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt_insert->bindParam(':note', $note, PDO::PARAM_STR);
        if ($stmt_insert->execute()) {
            echo json_encode(["status" => "success", "message" => "Nota salva com sucesso."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao salvar a nota."]);
        }
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
