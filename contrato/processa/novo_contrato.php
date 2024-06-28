<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


    $empresaID = $_POST['empresa'];
    $active = "1";

    $cont_insert = false;

    $sql = "INSERT INTO contract (empresa_id, active)
        VALUES (:empresa_id, :active)";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->bindParam(':empresa_id', $empresaID);
    $stmt1->bindParam(':active', $active);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        header("Location: /contrato/index.php");
        exit();
    } else {
        header("Location: /contrato/index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
