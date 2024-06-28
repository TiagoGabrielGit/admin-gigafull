<?php
session_start();

if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    $itemContratoID = $_POST['itemContratoID'];
    $contract_service_id = $_POST['selectService'];
    $iten_service = $_POST['itemService'];
    $active = "1";

    $cont_insert = false;

    $sql = "INSERT INTO contract_iten_service (contract_service_id, iten_service, active) VALUES (:contract_service_id, :iten_service, :active)";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->bindParam(':contract_service_id', $contract_service_id);
    $stmt1->bindParam(':iten_service', $iten_service);
    $stmt1->bindParam(':active', $active);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        header("Location: /contrato/view_itemservice.php?id=$itemContratoID");
        exit();
    } else {
        header("Location: /contrato/view_itemservice.php?id=$itemContratoID");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
