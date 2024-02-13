<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_id = $_SESSION['id'];

        $chamado_id = $_POST['reabertura_idChamado'];

        $text_reabertura = '<b> Relato de Reabertura </b> <br><br>' . $_POST['text_reabertura'];

        require "../../../conexoes/conexao_pdo.php";

        // Atualizar o status do chamado
        $sql_update = "UPDATE chamados SET status_id = 1 WHERE id = :chamado_id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':chamado_id', $chamado_id);
        $stmt_update->execute();

        // Inserir na tabela chamado_relato
        $sql_insert = "INSERT INTO chamado_relato (chamado_id, relator_id, relato, relato_hora_inicial, relato_hora_final, seconds_worked, private)
                         VALUES (:chamado_id, :relator_id, :relato, NOW(), NOW(), '0', '0')";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->bindParam(':chamado_id', $chamado_id);
        $stmt_insert->bindParam(':relator_id', $usuario_id);
        $stmt_insert->bindParam(':relato', $text_reabertura);
        $stmt_insert->execute();

        // Redirecionar para a página de visualização do chamado
        header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
        exit();
    } else {
        header("Location: /index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
