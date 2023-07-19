<?php
session_start();

if ($_SESSION['id'] && $_SERVER["REQUEST_METHOD"] == "POST") {
    $id_chamado = $_POST["conf_id_chamado"];
    $nova_data_prevista = $_POST["conf_data_entrega"];

    try {
        require "../../../conexoes/conexao_pdo.php";

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crie a consulta SQL para atualizar a coluna "data_prevista_conclusao"
        $sql = "UPDATE chamados SET data_prevista_conclusao = :nova_data_prevista WHERE id = :id_chamado";

        // Prepare a consulta SQL
        $stmt = $pdo->prepare($sql);

        // Associe os parâmetros com os valores
        $stmt->bindParam(':nova_data_prevista', $nova_data_prevista);
        $stmt->bindParam(':id_chamado', $id_chamado);

        // Execute a consulta SQL
        $stmt->execute();

        header("Location: /servicedesk/consultar_chamados/view.php?id=$id_chamado");
        exit;
    } catch (PDOException $e) {
        header("Location: /servicedesk/consultar_chamados/view.php?id=$id_chamado");
        exit;
    }

    $pdo = null;
}
