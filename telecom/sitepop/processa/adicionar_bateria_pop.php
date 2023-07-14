<?php
session_start();

if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../conexoes/conexao_pdo.php";

    $add_bateria_pop_id = $_POST['add_bateria_pop_id'];
    $add_bateria_bateria = $_POST['add_bateria_bateria'];
    $data_instalacao = $_POST['data_instalacao'];

    $status = "1";

    try {
        // Prepare the insert statement
        $stmt = $pdo->prepare("INSERT INTO pop_baterias_in_use (pop_id, bateria_id, status, data_instalacao) VALUES (:pop_id, :bateria_id, :status, :data_instalacao)");

        // Bind the parameters
        $stmt->bindParam(':pop_id', $add_bateria_pop_id);
        $stmt->bindParam(':bateria_id', $add_bateria_bateria);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':data_instalacao', $data_instalacao);


        // Execute the statement
        if ($stmt->execute()) {
            header("Location: /telecom/sitepop/view.php?id=$add_bateria_pop_id");
            exit();
        } else {
            header("Location: /telecom/sitepop/view.php?id=$add_bateria_pop_id");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: /telecom/sitepop/view.php?id=$add_bateria_pop_id");
        exit();
    }
}
