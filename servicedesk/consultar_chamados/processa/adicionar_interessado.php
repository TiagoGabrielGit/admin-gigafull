<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty('interessadosIdChamado') || empty('interessadosEmail')) {
        $idChamado = $_POST['interessadosIdChamado'];

        header("Location: ../view.php?id=$idChamado.php");
        exit();
    } else {
        $idChamado = $_POST['interessadosIdChamado'];
        $interessadosEmail = $_POST['interessadosEmail'];
        require "../../../conexoes/conexao_pdo.php";
        $sql = "INSERT INTO chamados_interessados (chamado_id, email, active) VALUES (:idChamado, :email, '1')";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':idChamado', $idChamado);
        $stmt->bindParam(':email', $interessadosEmail);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
