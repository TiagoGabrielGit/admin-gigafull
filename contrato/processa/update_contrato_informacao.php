<?php
session_start();

if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    $contractIDInformation = $_POST['contractIDInformation'];
    $statusContrato = $_POST['statusContrato'];

    $data = [
        'contractIDInformation' => $contractIDInformation,
        'statusContrato' => $statusContrato,
    ];

    $sql2 = "UPDATE contract SET active=:statusContrato WHERE id=:contractIDInformation";
    $stmt2 = $pdo->prepare($sql2);


    if ($stmt2->execute($data)) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        header("Location: /contrato/view_info.php?id=$contractIDInformation");
        exit();
    } else {
        header("Location: /contrato/view_info.php?id=$contractIDInformation");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
