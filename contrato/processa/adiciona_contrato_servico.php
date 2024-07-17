<?php
session_start();

if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    $serviceContract = $_POST['serviceContract'];
    $serviceContratoID = $_POST['serviceContratoID'];
    $active = "1";

    $cont_insert = false;

    $sql = "INSERT INTO contract_service (contract_id, service_id, created, tipo_cobranca, active) VALUES (:contract_id, :service_id, NOW(), 1, :active)";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->bindParam(':service_id', $serviceContract);
    $stmt1->bindParam(':contract_id', $serviceContratoID);
    $stmt1->bindParam(':active', $active);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        header("Location: /contrato/view_service.php?id=$serviceContratoID");
        exit();
    } else {
        header("Location: /contrato/view_service.php?id=$serviceContratoID");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
